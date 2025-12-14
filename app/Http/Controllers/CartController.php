<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        } else {
            $cartItems = Cart::with('product')->where('session_id', session()->getId())->get();
        }

        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (Auth::check()) {
            $cartItem = Cart::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'product_id' => $request->product_id,
                    'color' => $request->color,
                    'size' => $request->size,
                ],
                [
                    'quantity' => $request->quantity,
                    'price' => $product->price,
                ]
            );
        } else {
            $cartItem = Cart::updateOrCreate(
                [
                    'session_id' => session()->getId(),
                    'product_id' => $request->product_id,
                    'color' => $request->color,
                    'size' => $request->size,
                ],
                [
                    'quantity' => $request->quantity,
                    'price' => $product->price,
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cart_count' => $this->getCartCount()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::findOrFail($request->cart_id);
        
        if (Auth::check()) {
            if ($cartItem->user_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
        } else {
            if ($cartItem->session_id !== session()->getId()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart_count' => $this->getCartCount()
        ]);
    }

    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);
        
        if (Auth::check()) {
            if ($cartItem->user_id !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
        } else {
            if ($cartItem->session_id !== session()->getId()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'cart_count' => $this->getCartCount()
        ]);
    }

    public function getCartCount()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->sum('quantity');
        } else {
            return Cart::where('session_id', session()->getId())->sum('quantity');
        }
    }

    public function getCartData()
    {
        if (Auth::check()) {
            $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        } else {
            $cartItems = Cart::with('product')->where('session_id', session()->getId())->get();
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->price;
        }

        return response()->json([
            'items' => $cartItems,
            'count' => $cartItems->sum('quantity'),
            'total' => $total
        ]);
    }
}
