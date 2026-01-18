@extends('admin.layout')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Site Settings</h2>
            <p class="text-gray-600 mt-1">Manage your website settings and branding</p>
        </div>

        <!-- Logo Upload Section -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Website Logo</h3>

            <!-- Current Logo Preview -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Logo</label>
                <div
                    class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-6 flex justify-center items-center">
                    <img src="{{ asset($logo) }}" alt="Current Logo" class="max-h-32 object-contain">
                </div>
            </div>

            <!-- Upload Form -->
            <form action="{{ route('admin.settings.update-logo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                        Upload New Logo
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="file" name="logo" id="logo" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            required>
                    </div>
                    @error('logo')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">
                        Accepted formats: JPEG, PNG, JPG, GIF, SVG, WEBP. Maximum size: 2MB
                    </p>
                </div>

                <!-- Preview Section -->
                <div id="preview-container" class="mb-6 hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                    <div
                        class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-6 flex justify-center items-center">
                        <img id="logo-preview" src="" alt="Logo Preview" class="max-h-32 object-contain">
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.dashboard') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Logo
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Preview uploaded image
            document.getElementById('logo').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('logo-preview').src = e.target.result;
                        document.getElementById('preview-container').classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
@endsection
