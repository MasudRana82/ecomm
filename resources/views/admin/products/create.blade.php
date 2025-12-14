@extends('admin.layout')

@section('title', 'Create Product')

@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Create Product</h2>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 mt-1">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category *</label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 mt-1">
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price *</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01"
                        min="0" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 mt-1">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="compare_price" class="block text-sm font-medium text-gray-700">Compare Price (Original
                        Price)</label>
                    <input type="number" name="compare_price" id="compare_price" value="{{ old('compare_price') }}"
                        step="0.01" min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 mt-1">
                    @error('compare_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity *</label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 0) }}" min="0"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 mt-1">
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700">SKU *</label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 mt-1">
                    @error('sku')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="colors" class="block text-sm font-medium text-gray-700">Colors (Comma
                        separated)</label>
                    <input type="text" name="colors" id="colors" value="{{ old('colors') }}"
                        placeholder="Red, Blue, Green"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 mt-1">
                    <p class="mt-1 text-xs text-gray-500">e.g. Red, Blue, Green</p>
                    @error('colors')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sizes" class="block text-sm font-medium text-gray-700">Sizes (Comma
                        separated)</label>
                    <input type="text" name="sizes" id="sizes" value="{{ old('sizes') }}"
                        placeholder="S, M, L, XL"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 mt-1">
                    <p class="mt-1 text-xs text-gray-500">e.g. S, M, L, XL</p>
                    @error('sizes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6 m-5">
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                    <textarea name="description" id="description" rows="4" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 mt-1">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="short_description" class="block text-sm font-medium text-gray-700">Short
                        Description</label>
                    <textarea name="short_description" id="short_description" rows="2"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 mt-1">{{ old('short_description') }}</textarea>
                    @error('short_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Main Image</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 mt-1">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700">Additional Images</label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 mt-1">
                    <p class="mt-1 text-sm text-gray-500">You can select multiple images</p>
                    @error('images')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                        {{ old('is_active') ? 'checked' : '' }}
                        class="h-4 w-4 text-custom-orange focus:ring-custom-orange border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1"
                        {{ old('is_featured') ? 'checked' : '' }}
                        class="h-4 w-4 text-custom-orange focus:ring-custom-orange border-gray-300 rounded">
                    <label for="is_featured" class="ml-2 block text-sm text-gray-900">Featured</label>
                </div>
            </div>
    </div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
        <a href="{{ route('admin.products.index') }}"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
            Cancel
        </a>
        <button type="submit" class="ml-3 btn-primary">
            Create Product
        </button>
    </div>
    </form>
    </div>
@endsection
