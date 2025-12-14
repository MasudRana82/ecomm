<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'sku' => 'required|unique:products,sku',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'colors' => 'nullable|string', // Comma separated string
            'sizes' => 'nullable|string', // Comma separated string
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $productData = $request->except(['image', 'images']);
        $productData['slug'] = Str::slug($request->name);
        $productData['is_active'] = $request->has('is_active');
        $productData['is_featured'] = $request->has('is_featured');
        
        // Process colors and sizes from comma-separated string to array
        if ($request->has('colors') && $request->colors) {
            $productData['colors'] = array_map('trim', explode(',', $request->colors));
        } else {
            $productData['colors'] = null;
        }

        if ($request->has('sizes') && $request->sizes) {
            $productData['sizes'] = array_map('trim', explode(',', $request->sizes));
        } else {
            $productData['sizes'] = null;
        }

        $product = Product::create($productData);

        // Handle single image upload
        if ($request->hasFile('image')) {
            $imagePath = $product->uploadImage($request->file('image'));
            $product->update(['image' => $imagePath]);
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $imagePaths = $product->uploadMultipleImages($request->file('images'));
            if ($imagePaths) {
                $product->update(['images' => $imagePaths]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'short_description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'sku' => 'required|unique:products,sku,' . $id,
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'colors' => 'nullable|string', // Comma separated string
            'sizes' => 'nullable|string', // Comma separated string
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $productData = $request->except(['image', 'images']);
        $productData['slug'] = Str::slug($request->name);
        $productData['is_active'] = $request->has('is_active');
        $productData['is_featured'] = $request->has('is_featured');

        // Process colors and sizes from comma-separated string to array
        if ($request->has('colors') && $request->colors) {
            $productData['colors'] = array_map('trim', explode(',', $request->colors));
        } else {
            $productData['colors'] = null;
        }

        if ($request->has('sizes') && $request->sizes) {
            $productData['sizes'] = array_map('trim', explode(',', $request->sizes));
        } else {
            $productData['sizes'] = null;
        }

        $product->update($productData);

        // Handle single image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                $product->deleteProductImage($product->image);
            }
            
            $imagePath = $product->uploadImage($request->file('image'));
            $product->update(['image' => $imagePath]);
        }

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $imagePaths = $product->uploadMultipleImages($request->file('images'));
            if ($imagePaths) {
                // Delete old multiple images if they exist
                if ($product->images) {
                    $product->deleteMultipleFiles($product->images);
                }
                
                $product->update(['images' => $imagePaths]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete product images if they exist
        if ($product->image) {
            $product->deleteProductImage($product->image);
        }
        
        if ($product->images) {
            $product->deleteMultipleFiles($product->images);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}