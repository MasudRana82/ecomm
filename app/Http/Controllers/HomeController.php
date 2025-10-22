<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     */
    public function index()
    {
        // Get featured products
        $products = Product::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->limit(10)  // Changed back to limit for homepage, no pagination needed
            ->get();
            
        // Get all categories
        $categories = Category::where('is_active', true)->get();
        
        return view('homepage', compact('products', 'categories'));
    }
}
