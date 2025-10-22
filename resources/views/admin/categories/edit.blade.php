@extends('admin.layout')

@section('title', 'Edit Category')

@section('content')
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Edit Category</h2>
        <a href="{{ route('admin.categories.index') }}" class="text-custom-orange hover:text-orange-700">
            <i class="fas fa-arrow-left mr-2"></i>Back to Categories
        </a>
    </div>
    
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Parent Category (Optional)</label>
                    <select name="parent_id" id="parent_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">None (Top Level Category)</option>
                        @foreach($categories as $cat)
                            @if($cat->id != $category->id) {{-- Prevent selecting itself as parent --}}
                                <option value="{{ $cat->id }}" {{ $cat->id == $category->parent_id ? 'selected' : '' }}>
                                    {{ str_repeat('-', $cat->level) . ' ' . $cat->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Category Image (Optional)</label>
                    @if($category->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $category->image) }}" alt="Current Image" class="w-32 h-32 object-cover rounded">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Leave empty to keep current image</p>
                </div>
                
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Display Order (Optional)</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $category->order) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1" 
                               {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save mr-2"></i>Update Category
                </button>
            </div>
        </div>
    </form>
</div>
@endsection