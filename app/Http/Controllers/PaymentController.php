<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Process payment for an order
     */
    public function processPayment(Request $request, $orderNumber)
    {
        $request->validate([
            'payment_method' => 'required|string|in:cash_on_delivery,credit_card,bkash,nagad'
        ]);

        if (auth()->check()) {
            $order = Order::where('order_number', $orderNumber)->where('user_id', auth()->id())->firstOrFail();
        } else {
            $order = Order::where('order_number', $orderNumber)->whereNull('user_id')->firstOrFail();
        }

        // For demo purposes, we'll just update the payment status based on method
        $paymentStatus = 'paid';
        
        if ($request->payment_method === 'cash_on_delivery') {
            $paymentStatus = 'pending'; // Will be paid on delivery
        }

        $order->update([
            'payment_method' => $request->payment_method,
            'payment_status' => $paymentStatus,
            'status' => $request->payment_method === 'cash_on_delivery' ? 'pending' : 'processing'
        ]);

        // Additional payment processing logic would go here for actual gateways
        switch ($request->payment_method) {
            case 'credit_card':
                // Process credit card payment with payment gateway
                $result = $this->processCreditCardPayment($order, $request);
                break;
            case 'bkash':
                // Process bKash payment
                $result = $this->processBkashPayment($order, $request);
                break;
            case 'nagad':
                // Process Nagad payment
                $result = $this->processNagadPayment($order, $request);
                break;
            case 'cash_on_delivery':
            default:
                // For COD, just confirm the order
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
     * Process credit card payment
     */
    private function processCreditCardPayment($order, $request)
    {
        // In a real application, you would integrate with Stripe, PayPal, etc.
        // For this demo, we'll simulate the payment process
        
        // Simulate payment processing (in real app, you'd call the payment gateway API)
        $paymentSuccessful = true; // Simulate success
        
        if ($paymentSuccessful) {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing'
            ]);
            
            return [
                'success' => true,
                'message' => 'Payment processed successfully via credit card.',
                'redirect' => route('orders.show', $order->order_number)
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Credit card payment failed. Please try again.'
            ];
        }
    }

    /**
     * Process bKash payment
     */
    private function processBkashPayment($order, $request)
    {
        // In a real application, you would integrate with bKash Payment API
        // For this demo, we'll simulate the payment process
        
        // Simulate payment processing
        $paymentSuccessful = true; // Simulate success
        
        if ($paymentSuccessful) {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing'
            ]);
            
            return [
                'success' => true,
                'message' => 'Payment processed successfully via bKash.',
                'redirect' => route('orders.show', $order->order_number)
            ];
        } else {
            return [
                'success' => false,
                'message' => 'bKash payment failed. Please try again.'
            ];
        }
    }

    /**
     * Process Nagad payment
     */
    private function processNagadPayment($order, $request)
    {
        // In a real application, you would integrate with Nagad Payment API
        // For this demo, we'll simulate the payment process
        
        // Simulate payment processing
        $paymentSuccessful = true; // Simulate success
        
        if ($paymentSuccessful) {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing'
            ]);
            
            return [
                'success' => true,
                'message' => 'Payment processed successfully via Nagad.',
                'redirect' => route('orders.show', $order->order_number)
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Nagad payment failed. Please try again.'
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