@extends('layouts.app')

@section('content')
    <div class="bg-white">
        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Edit {{ ucfirst($gateway->gateway_name) }} Payment Gateway</h1>
                <a href="{{ route('admin.payment-gateways.index') }}" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left"></i> Back to Gateways
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.payment-gateways.update', $gateway->id) }}" method="POST" class="max-w-3xl">
                @csrf
                @method('PUT')

                <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
                    <!-- Gateway Status -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Gateway Status</h3>

                        <div class="flex items-center space-x-6">
                            <div class="flex items-center">
                                <input type="radio" id="enabled" name="is_enabled" value="1"
                                    {{ $gateway->is_enabled ? 'checked' : '' }}
                                    class="h-4 w-4 text-custom-orange focus:ring-custom-orange border-gray-300">
                                <label for="enabled" class="ml-2 block text-sm font-medium text-gray-700">
                                    Enabled
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="disabled" name="is_enabled" value="0"
                                    {{ !$gateway->is_enabled ? 'checked' : '' }}
                                    class="h-4 w-4 text-custom-orange focus:ring-custom-orange border-gray-300">
                                <label for="disabled" class="ml-2 block text-sm font-medium text-gray-700">
                                    Disabled
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Gateway Mode -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Gateway Mode</h3>

                        <div class="flex items-center space-x-6">
                            <div class="flex items-center">
                                <input type="radio" id="sandbox" name="sandbox_mode" value="1"
                                    {{ $gateway->sandbox_mode ? 'checked' : '' }}
                                    class="h-4 w-4 text-custom-orange focus:ring-custom-orange border-gray-300">
                                <label for="sandbox" class="ml-2 block text-sm font-medium text-gray-700">
                                    Sandbox (Test Mode)
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="live" name="sandbox_mode" value="0"
                                    {{ !$gateway->sandbox_mode ? 'checked' : '' }}
                                    class="h-4 w-4 text-custom-orange focus:ring-custom-orange border-gray-300">
                                <label for="live" class="ml-2 block text-sm font-medium text-gray-700">
                                    Live (Production Mode)
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Gateway-Specific Configuration -->
                    <div class="pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">API Configuration</h3>

                        @if ($gateway->gateway_name === 'stripe')
                            <!-- Stripe Configuration -->
                            <div class="space-y-4">
                                <div>
                                    <label for="api_key" class="block text-sm font-medium text-gray-700 mb-2">
                                        Publishable Key <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="api_key" id="api_key"
                                        value="{{ old('api_key', $gateway->api_key) }}" placeholder="pk_test_..."
                                        class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-custom-orange focus:border-custom-orange">
                                    <p class="mt-1 text-xs text-gray-500">Your Stripe publishable API key</p>
                                </div>

                                <div>
                                    <label for="api_secret" class="block text-sm font-medium text-gray-700 mb-2">
                                        Secret Key <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="api_secret" id="api_secret"
                                        value="{{ old('api_secret', $gateway->api_secret) }}" placeholder="sk_test_..."
                                        class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-custom-orange focus:border-custom-orange">
                                    <p class="mt-1 text-xs text-gray-500">Your Stripe secret API key</p>
                                </div>

                                <div>
                                    <label for="webhook_secret" class="block text-sm font-medium text-gray-700 mb-2">
                                        Webhook Secret (Optional)
                                    </label>
                                    <input type="text" name="webhook_secret" id="webhook_secret"
                                        value="{{ old('webhook_secret', $gateway->webhook_secret) }}"
                                        placeholder="whsec_..."
                                        class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-custom-orange focus:border-custom-orange">
                                    <p class="mt-1 text-xs text-gray-500">Webhook signing secret for payment confirmations
                                    </p>
                                </div>
                            </div>
                        @elseif ($gateway->gateway_name === 'sslcommerz')
                            <!-- SSLCommerz Configuration -->
                            <div class="space-y-4">
                                <div>
                                    <label for="store_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        Store ID <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="store_id" id="store_id"
                                        value="{{ old('store_id', $gateway->store_id) }}"
                                        placeholder="Your SSLCommerz Store ID"
                                        class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-custom-orange focus:border-custom-orange">
                                    <p class="mt-1 text-xs text-gray-500">Your SSLCommerz store ID</p>
                                </div>

                                <div>
                                    <label for="store_password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Store Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="store_password" id="store_password"
                                        value="{{ old('store_password', $gateway->store_password) }}"
                                        placeholder="Your SSLCommerz Store Password"
                                        class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-custom-orange focus:border-custom-orange">
                                    <p class="mt-1 text-xs text-gray-500">Your SSLCommerz store password</p>
                                </div>
                            </div>
                        @elseif ($gateway->gateway_name === 'bkash')
                            <!-- Bkash Configuration -->
                            <div class="space-y-4">
                                <div>
                                    <label for="app_key" class="block text-sm font-medium text-gray-700 mb-2">
                                        App Key <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="app_key" id="app_key"
                                        value="{{ old('app_key', $gateway->app_key) }}" placeholder="Your Bkash App Key"
                                        class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-custom-orange focus:border-custom-orange">
                                    <p class="mt-1 text-xs text-gray-500">Your Bkash application key</p>
                                </div>

                                <div>
                                    <label for="app_secret" class="block text-sm font-medium text-gray-700 mb-2">
                                        App Secret <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="app_secret" id="app_secret"
                                        value="{{ old('app_secret', $gateway->app_secret) }}"
                                        placeholder="Your Bkash App Secret"
                                        class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-custom-orange focus:border-custom-orange">
                                    <p class="mt-1 text-xs text-gray-500">Your Bkash application secret</p>
                                </div>

                                <div>
                                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                        Username <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="username" id="username"
                                        value="{{ old('username', $gateway->username) }}"
                                        placeholder="Your Bkash Username"
                                        class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-custom-orange focus:border-custom-orange">
                                    <p class="mt-1 text-xs text-gray-500">Your Bkash merchant username</p>
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <input type="password" name="password" id="password"
                                        value="{{ old('password', $gateway->password) }}"
                                        placeholder="Your Bkash Password"
                                        class="w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-custom-orange focus:border-custom-orange">
                                    <p class="mt-1 text-xs text-gray-500">Your Bkash merchant password</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Documentation Links -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">
                            <i class="fas fa-book"></i> Documentation
                        </h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            @if ($gateway->gateway_name === 'stripe')
                                <li><a href="https://stripe.com/docs/keys" target="_blank"
                                        class="text-blue-600 hover:underline">
                                        <i class="fas fa-external-link-alt"></i> Get Stripe API Keys
                                    </a></li>
                                <li><a href="https://stripe.com/docs/webhooks" target="_blank"
                                        class="text-blue-600 hover:underline">
                                        <i class="fas fa-external-link-alt"></i> Stripe Webhooks Documentation
                                    </a></li>
                            @elseif ($gateway->gateway_name === 'sslcommerz')
                                <li><a href="https://developer.sslcommerz.com/" target="_blank"
                                        class="text-blue-600 hover:underline">
                                        <i class="fas fa-external-link-alt"></i> SSLCommerz Developer Documentation
                                    </a></li>
                            @elseif ($gateway->gateway_name === 'bkash')
                                <li><a href="https://developer.bka.sh/" target="_blank"
                                        class="text-blue-600 hover:underline">
                                        <i class="fas fa-external-link-alt"></i> Bkash Developer Documentation
                                    </a></li>
                            @endif
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('admin.payment-gateways.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-custom-orange text-white rounded-md hover:bg-custom-orange-dark">
                            <i class="fas fa-save"></i> Save Configuration
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
