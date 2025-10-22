<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryAdminController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = $this->getCategoriesHierarchy();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $categoryData = $request->except(['image']);
        $categoryData['slug'] = Str::slug($request->name);
        $categoryData['is_active'] = $request->has('is_active');
        $categoryData['parent_id'] = $request->parent_id ?: null;
        $categoryData['order'] = $request->order ?: 0;

        $category = Category::create($categoryData);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $category->uploadImage($request->file('image'));
            $category->update(['image' => $imagePath]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = $this->getCategoriesHierarchy($id); // Exclude current category from parent options
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $categoryData = $request->except(['image']);
        $categoryData['slug'] = Str::slug($request->name);
        $categoryData['is_active'] = $request->has('is_active');
        $categoryData['parent_id'] = $request->parent_id ?: null;
        $categoryData['order'] = $request->order ?: 0;

        $category->update($categoryData);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                $category->deleteCategoryImage($category->image);
            }
            
            $imagePath = $category->uploadImage($request->file('image'));
            $category->update(['image' => $imagePath]);
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Delete category image if it exists
        if ($category->image) {
            $category->deleteCategoryImage($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
    
    private function getCategoriesHierarchy($excludeId = null)
    {
        $query = Category::query();
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $categories = $query->orderBy('order')->get();
        
        // Add a level property to track hierarchy depth
        $categories->transform(function ($category) {
            $level = 0;
            $parent = $category->parent;
            while ($parent) {
                $level++;
                $parent = $parent->parent;
            }
            $category->level = $level;
            return $category;
        });
        
        return $categories;
    }
}