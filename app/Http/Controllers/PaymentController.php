<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentGatewaySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Process payment for an order
     */
    public function processPayment(Request $request, $orderNumber)
    {
        $request->validate([
            'payment_method' => 'required|string|in:cash_on_delivery,stripe,sslcommerz,bkash'
        ]);

        if (auth()->check()) {
            $order = Order::where('order_number', $orderNumber)->where('user_id', auth()->id())->firstOrFail();
        } else {
            $order = Order::where('order_number', $orderNumber)->whereNull('user_id')->firstOrFail();
        }

        // Process payment based on method
        switch ($request->payment_method) {
            case 'stripe':
                $result = $this->processStripePayment($order, $request);
                break;
            case 'sslcommerz':
                $result = $this->processSSLCommerzPayment($order, $request);
                break;
            case 'bkash':
                $result = $this->processBkashPayment($order, $request);
                break;
            case 'cash_on_delivery':
            default:
                // For COD, just confirm the order
                $order->update([
                    'payment_status' => 'pending',
                    'status' => 'pending'
                ]);

                $result = [
                    'success' => true,
                    'message' => 'Order confirmed. Payment will be collected on delivery.',
                    'redirect' => route('orders.show', $order->order_number)
                ];
                break;
        }

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'redirect' => $result['redirect'] ?? route('orders.show', $order->order_number)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }
    }

    /**
     * Process Stripe payment
     */
    private function processStripePayment($order, $request)
    {
        try {
            $gateway = PaymentGatewaySetting::getGateway('stripe');

            if (!$gateway || !$gateway->is_enabled) {
                return [
                    'success' => false,
                    'message' => 'Stripe payment gateway is not available.'
                ];
            }

            // Initialize Stripe
            \Stripe\Stripe::setApiKey($gateway->api_secret);

            // Create Stripe Checkout Session
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'bdt',
                        'product_data' => [
                            'name' => 'Order #' . $order->order_number,
                        ],
                        'unit_amount' => $order->total * 100, // Stripe uses cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', $order->order_number) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel', $order->order_number),
                'metadata' => [
                    'order_number' => $order->order_number,
                ],
            ]);

            return [
                'success' => true,
                'message' => 'Redirecting to Stripe payment...',
                'redirect' => $session->url
            ];
        } catch (\Exception $e) {
            Log::error('Stripe Payment Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Payment processing failed. Please try again.'
            ];
        }
    }

    /**
     * Process SSLCommerz payment
     */
    private function processSSLCommerzPayment($order, $request)
    {
        try {
            $gateway = PaymentGatewaySetting::getGateway('sslcommerz');

            if (!$gateway || !$gateway->is_enabled) {
                return [
                    'success' => false,
                    'message' => 'SSLCommerz payment gateway is not available.'
                ];
            }

            $baseUrl = $gateway->sandbox_mode
                ? 'https://sandbox.sslcommerz.com'
                : 'https://securepay.sslcommerz.com';

            $postData = [
                'store_id' => $gateway->store_id,
                'store_passwd' => $gateway->store_password,
                'total_amount' => $order->total,
                'currency' => 'BDT',
                'tran_id' => $order->order_number,
                'success_url' => route('payment.success', $order->order_number),
                'fail_url' => route('payment.failure', $order->order_number),
                'cancel_url' => route('payment.cancel', $order->order_number),
                'cus_name' => $order->shipping_address['name'] ?? 'Customer',
                'cus_email' => auth()->user()->email ?? 'customer@example.com',
                'cus_add1' => $order->shipping_address['address'] ?? 'N/A',
                'cus_city' => $order->shipping_address['city'] ?? 'N/A',
                'cus_country' => 'Bangladesh',
                'cus_phone' => $order->shipping_address['phone'] ?? 'N/A',
                'shipping_method' => 'NO',
                'product_name' => 'Order #' . $order->order_number,
                'product_category' => 'General',
                'product_profile' => 'general',
            ];

            $response = Http::asForm()->post($baseUrl . '/gwprocess/v4/api.php', $postData);
            $result = $response->json();

            if (isset($result['status']) && $result['status'] === 'SUCCESS') {
                return [
                    'success' => true,
                    'message' => 'Redirecting to SSLCommerz payment...',
                    'redirect' => $result['GatewayPageURL']
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'SSLCommerz payment initialization failed.'
                ];
            }
        } catch (\Exception $e) {
            Log::error('SSLCommerz Payment Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Payment processing failed. Please try again.'
            ];
        }
    }

    /**
     * Process Bkash payment
     */
    private function processBkashPayment($order, $request)
    {
        try {
            $gateway = PaymentGatewaySetting::getGateway('bkash');

            if (!$gateway || !$gateway->is_enabled) {
                return [
                    'success' => false,
                    'message' => 'Bkash payment gateway is not available.'
                ];
            }

            $baseUrl = $gateway->sandbox_mode
                ? 'https://tokenized.sandbox.bka.sh/v1.2.0-beta'
                : 'https://tokenized.pay.bka.sh/v1.2.0-beta';

            // Step 1: Get Auth Token
            $authResponse = Http::withHeaders([
                'username' => $gateway->username,
                'password' => $gateway->password,
            ])->post($baseUrl . '/tokenized/checkout/token/grant', [
                'app_key' => $gateway->app_key,
                'app_secret' => $gateway->app_secret,
            ]);

            $authData = $authResponse->json();

            if (!isset($authData['id_token'])) {
                return [
                    'success' => false,
                    'message' => 'Bkash authentication failed.'
                ];
            }

            $idToken = $authData['id_token'];

            // Step 2: Create Payment
            $paymentResponse = Http::withHeaders([
                'Authorization' => $idToken,
                'X-APP-Key' => $gateway->app_key,
            ])->post($baseUrl . '/tokenized/checkout/create', [
                'mode' => '0011',
                'payerReference' => ' ',
                'callbackURL' => route('payment.success', $order->order_number),
                'amount' => $order->total,
                'currency' => 'BDT',
                'intent' => 'sale',
                'merchantInvoiceNumber' => $order->order_number,
            ]);

            $paymentData = $paymentResponse->json();

            if (isset($paymentData['bkashURL'])) {
                return [
                    'success' => true,
                    'message' => 'Redirecting to Bkash payment...',
                    'redirect' => $paymentData['bkashURL']
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Bkash payment initialization failed.'
                ];
            }
        } catch (\Exception $e) {
            Log::error('Bkash Payment Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Payment processing failed. Please try again.'
            ];
        }
    }

    /**
     * Handle payment success callback
     */
    public function paymentSuccess(Request $request, $orderNumber)
    {
        if (auth()->check()) {
            $order = Order::where('order_number', $orderNumber)->where('user_id', auth()->id())->firstOrFail();
        } else {
            $order = Order::where('order_number', $orderNumber)->whereNull('user_id')->firstOrFail();
        }

        $order->update([
            'payment_status' => 'paid',
            'status' => 'processing'
        ]);

        return redirect()->route('orders.show', $order->order_number)
            ->with('success', 'Payment completed successfully!');
    }

    /**
     * Handle payment failure callback
     */
    public function paymentFailure(Request $request, $orderNumber)
    {
        if (auth()->check()) {
            $order = Order::where('order_number', $orderNumber)->where('user_id', auth()->id())->firstOrFail();
        } else {
            $order = Order::where('order_number', $orderNumber)->whereNull('user_id')->firstOrFail();
        }

        $order->update([
            'payment_status' => 'failed',
            'status' => 'pending'
        ]);

        return redirect()->route('orders.show', $order->order_number)
            ->with('error', 'Payment failed. Please try again.');
    }

    /**
     * Handle payment cancellation
     */
    public function paymentCancel(Request $request, $orderNumber)
    {
        if (auth()->check()) {
            $order = Order::where('order_number', $orderNumber)->where('user_id', auth()->id())->firstOrFail();
        } else {
            $order = Order::where('order_number', $orderNumber)->whereNull('user_id')->firstOrFail();
        }

        return redirect()->route('orders.show', $order->order_number)
            ->with('info', 'Payment was cancelled. You can try again.');
    }
}
