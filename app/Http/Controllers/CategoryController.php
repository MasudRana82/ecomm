<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        // Get products in this category
        $products = Product::with('category')
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->paginate(12);
            
        // Get all categories for the sidebar
        $categories = Category::where('is_active', true)->get();

        return view('products.index', compact('products', 'categories'));
    }
}
