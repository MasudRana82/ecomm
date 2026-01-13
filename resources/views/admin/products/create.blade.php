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
                    <input type="hidden" name="description" id="description-hidden" value="{{ old('description') }}">
                    <div id="description-editor" style="height: 300px; background: white;"
                        class="border border-gray-300 rounded-md mt-1"></div>
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

                <div id="color-images-section" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Color-Specific Images</label>
                    <p class="text-xs text-gray-500 mb-3">Upload images for each color variant. These images will be
                        displayed when users select a color.</p>
                    <div id="color-images-container" class="space-y-3">
                        <!-- Color image inputs will be dynamically added here -->
                    </div>
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

    <!-- Quill WYSIWYG Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Quill Editor
            var quill = new Quill('#description-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        [{
                            'align': []
                        }],
                        ['link'],
                        ['clean']
                    ]
                },
                placeholder: 'Write product description here...'
            });

            // Sync Quill content with hidden input
            var hiddenInput = document.getElementById('description-hidden');

            // Set initial content if exists
            if (hiddenInput.value) {
                quill.root.innerHTML = hiddenInput.value;
            }

            // Update hidden input on text change
            quill.on('text-change', function() {
                hiddenInput.value = quill.root.innerHTML;
            });

            // Before form submit, ensure hidden input is updated
            document.querySelector('form').addEventListener('submit', function() {
                hiddenInput.value = quill.root.innerHTML;
            });

            const colorsInput = document.getElementById('colors');
            const colorImagesSection = document.getElementById('color-images-section');
            const colorImagesContainer = document.getElementById('color-images-container');

            colorsInput.addEventListener('input', function() {
                const colorsValue = this.value.trim();

                if (colorsValue) {
                    const colors = colorsValue.split(',').map(c => c.trim()).filter(c => c);

                    if (colors.length > 0) {
                        colorImagesSection.classList.remove('hidden');
                        colorImagesContainer.innerHTML = '';

                        colors.forEach(color => {
                            const colorDiv = document.createElement('div');
                            colorDiv.className = 'border border-gray-200 rounded-md p-3 bg-gray-50';
                            colorDiv.innerHTML = `
                                <label class="block text-sm font-medium text-gray-700 mb-1">${color}</label>
                                <input type="file" name="color_images[${color}]" accept="image/*"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                            `;
                            colorImagesContainer.appendChild(colorDiv);
                        });
                    } else {
                        colorImagesSection.classList.add('hidden');
                    }
                } else {
                    colorImagesSection.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
