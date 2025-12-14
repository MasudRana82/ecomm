<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    public function show($orderNumber)
    {
        if (Auth::check()) {
            $order = Order::where('order_number', $orderNumber)->where('user_id', Auth::id())->firstOrFail();
        } else {
            $order = Order::where('order_number', $orderNumber)->whereNull('user_id')->firstOrFail();
        }
        
        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        // Get cart items based on authentication status
        if (Auth::check()) {
            $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        } else {
            $cartItems = Cart::with('product')->where('session_id', session()->getId())->get();
        }
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        
        $tax = $subtotal * 0.05; // 5% tax
        $shipping = 50; // Fixed shipping cost
        $total = $subtotal + $tax + $shipping;

        return view('checkout', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|array',
            'billing_address' => 'required|array',
            'payment_method' => 'required|string',
        ]);

        // Get cart items based on authentication status
        if (Auth::check()) {
            $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        } else {
            $cartItems = Cart::with('product')->where('session_id', session()->getId())->get();
        }
        
        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Cart is empty']);
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        
        $tax = $subtotal * 0.05; // 5% tax
        $shipping = 50; // Fixed shipping cost
        $total = $subtotal + $tax + $shipping;

        // Create order
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'user_id' => Auth::check() ? Auth::id() : null,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $total,
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending', // Will be updated after payment
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->quantity * $item->price,
                'color' => $item->color,
                'size' => $item->size,
            ]);
            
            // Reduce product stock
            $product = $item->product;
            $product->decrement('quantity', $item->quantity);
        }

        // Clear cart
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            Cart::where('session_id', session()->getId())->delete();
        }

        // Process payment based on method
        if ($request->payment_method === 'cash_on_delivery') {
            // For COD, just update status and return success
            $order->update([
                'payment_status' => 'pending', // Payment will be collected on delivery
                'status' => 'pending' // Order is pending until delivery
            ]);

            return response()->json([
                'success' => true,
                'order_number' => $order->order_number,
                'message' => 'Order placed successfully. Payment will be collected on delivery.'
            ]);
        } else {
            // For online payments, redirect to payment processing
            return response()->json([
                'success' => true,
                'order_number' => $order->order_number,
                'redirect' => route('payment.process', $order->order_number),
                'message' => 'Processing payment...'
            ]);
        }
    }
}
