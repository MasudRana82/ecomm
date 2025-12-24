@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">Edit Product</h2>
            <a href="{{ route('admin.products.index') }}" class="text-custom-orange hover:text-orange-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to Products
            </a>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category_id" id="category_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                        <input type="number" step="0.01" name="price" id="price"
                            value="{{ old('price', $product->price) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="compare_price" class="block text-sm font-medium text-gray-700 mb-1">Compare Price
                            (Optional)</label>
                        <input type="number" step="0.01" name="compare_price" id="compare_price"
                            value="{{ old('compare_price', $product->compare_price) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @error('compare_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @error('sku')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <input type="number" name="quantity" id="quantity"
                            value="{{ old('quantity', $product->quantity) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="colors" class="block text-sm font-medium text-gray-700 mb-1">Colors (Comma
                            separated)</label>
                        <input type="text" name="colors" id="colors"
                            value="{{ old('colors', is_array($product->colors) ? implode(', ', $product->colors) : '') }}"
                            placeholder="Red, Blue, Green"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">e.g. Red, Blue, Green</p>
                        @error('colors')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sizes" class="block text-sm font-medium text-gray-700 mb-1">Sizes (Comma
                            separated)</label>
                        <input type="text" name="sizes" id="sizes"
                            value="{{ old('sizes', is_array($product->sizes) ? implode(', ', $product->sizes) : '') }}"
                            placeholder="S, M, L, XL"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">e.g. S, M, L, XL</p>
                        @error('sizes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">Short
                            Description (Optional)</label>
                        <textarea name="short_description" id="short_description" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('short_description', $product->short_description) }}</textarea>
                        @error('short_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="5"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Main Image</label>
                        @if ($product->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image"
                                    class="w-32 h-32 object-cover rounded">
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
                        <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Additional
                            Images</label>
                        @if ($product->images && is_array($product->images) && count($product->images) > 0)
                            <div class="grid grid-cols-3 gap-2 mb-2">
                                @foreach ($product->images as $image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="Additional Image"
                                        class="w-20 h-20 object-cover rounded">
                                @endforeach
                            </div>
                        @endif
                        <input type="file" name="images[]" id="images" multiple
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @error('images')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Select multiple files to upload additional images</p>
                    </div>

                    <div id="color-images-section"
                        class="{{ $product->colors && count($product->colors) > 0 ? '' : 'hidden' }}">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Color-Specific Images</label>
                        <p class="text-xs text-gray-500 mb-3">Upload images for each color variant. These images will be
                            displayed when users select a color.</p>
                        <div id="color-images-container" class="space-y-3">
                            @if ($product->colors && count($product->colors) > 0)
                                @foreach ($product->colors as $color)
                                    <div class="border border-gray-200 rounded-md p-3 bg-gray-50">
                                        <label
                                            class="block text-sm font-medium text-gray-700 mb-1">{{ $color }}</label>
                                        @if ($product->color_images && isset($product->color_images[$color]))
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $product->color_images[$color]) }}"
                                                    alt="{{ $color }}"
                                                    class="w-20 h-20 object-cover rounded border border-gray-300">
                                                <p class="text-xs text-gray-500 mt-1">Current image for
                                                    {{ $color }}</p>
                                            </div>
                                        @endif
                                        <input type="file" name="color_images[{{ $color }}]" accept="image/*"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                        <p class="text-xs text-gray-500 mt-1">Upload new image to replace existing one</p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                        </div>

                        <div class="flex items-center mt-2">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="is_featured" class="ml-2 block text-sm text-gray-900">Featured</label>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>Update Product
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colorsInput = document.getElementById('colors');
            const colorImagesSection = document.getElementById('color-images-section');
            const colorImagesContainer = document.getElementById('color-images-container');
            const existingColorImages = @json($product->color_images ?? []);

            // Initial check in case colors are already present on page load
            const initialColorsValue = colorsInput.value.trim();
            if (initialColorsValue) {
                const initialColors = initialColorsValue.split(',').map(c => c.trim()).filter(c => c);
                if (initialColors.length > 0) {
                    colorImagesSection.classList.remove('hidden');
                    // No need to clear container here, as it's already populated by PHP for existing colors
                    // However, if we want to regenerate based on input, we would clear and re-add.
                    // For an edit form, the PHP rendering is usually sufficient for initial state.
                    // The JS should primarily handle changes after page load.
                }
            }


            colorsInput.addEventListener('input', function() {
                const colorsValue = this.value.trim();

                if (colorsValue) {
                    const colors = colorsValue.split(',').map(c => c.trim()).filter(c => c);

                    if (colors.length > 0) {
                        colorImagesSection.classList.remove('hidden');
                        colorImagesContainer.innerHTML = ''; // Clear existing dynamic inputs

                        colors.forEach(color => {
                            const colorDiv = document.createElement('div');
                            colorDiv.className = 'border border-gray-200 rounded-md p-3 bg-gray-50';

                            let imagePreview = '';
                            if (existingColorImages[color]) {
                                imagePreview = `
                                <div class="mb-2">
                                    <img src="{{ asset('storage') }}/${existingColorImages[color]}" 
                                         alt="${color}" 
                                         class="w-20 h-20 object-cover rounded border border-gray-300">
                                    <p class="text-xs text-gray-500 mt-1">Current image for ${color}</p>
                                </div>
                            `;
                            }

                            colorDiv.innerHTML = `
                            <label class="block text-sm font-medium text-gray-700 mb-1">${color}</label>
                            ${imagePreview}
                            <input type="file" name="color_images[${color}]" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <p class="text-xs text-gray-500 mt-1">${imagePreview ? 'Upload new image to replace existing one' : 'Upload image for this color'}</p>
                        `;
                            colorImagesContainer.appendChild(colorDiv);
                        });
                    } else {
                        colorImagesSection.classList.add('hidden');
                        colorImagesContainer.innerHTML = ''; // Clear if no valid colors
                    }
                } else {
                    colorImagesSection.classList.add('hidden');
                    colorImagesContainer.innerHTML = ''; // Clear if input is empty
                }
            });
        });
    </script>
@endsection
