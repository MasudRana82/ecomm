@extends('layouts.app')

@section('content')
    <div class="bg-white">
        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Payment Gateway Settings</h1>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Gateway Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mode
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Configuration
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($gateways as $gateway)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if ($gateway->gateway_name === 'stripe')
                                            <div
                                                class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-indigo-100 rounded-full">
                                                <i class="fab fa-stripe text-indigo-600 text-xl"></i>
                                            </div>
                                        @elseif ($gateway->gateway_name === 'sslcommerz')
                                            <div
                                                class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-green-100 rounded-full">
                                                <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                                            </div>
                                        @elseif ($gateway->gateway_name === 'bkash')
                                            <div
                                                class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-pink-100 rounded-full">
                                                <i class="fas fa-mobile-alt text-pink-600 text-xl"></i>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ ucfirst($gateway->gateway_name) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($gateway->is_enabled)
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Enabled
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Disabled
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($gateway->sandbox_mode)
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Sandbox
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Live
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if ($gateway->gateway_name === 'stripe')
                                        {{ $gateway->api_key ? 'Configured' : 'Not Configured' }}
                                    @elseif ($gateway->gateway_name === 'sslcommerz')
                                        {{ $gateway->store_id ? 'Configured' : 'Not Configured' }}
                                    @elseif ($gateway->gateway_name === 'bkash')
                                        {{ $gateway->app_key ? 'Configured' : 'Not Configured' }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.payment-gateways.edit', $gateway->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.payment-gateways.toggle', $gateway->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="{{ $gateway->is_enabled ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}">
                                            <i class="fas fa-{{ $gateway->is_enabled ? 'toggle-on' : 'toggle-off' }}"></i>
                                            {{ $gateway->is_enabled ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-blue-800 mb-2">
                    <i class="fas fa-info-circle"></i> Important Information
                </h3>
                <ul class="text-sm text-blue-700 list-disc list-inside space-y-1">
                    <li>Cash on Delivery is always enabled by default</li>
                    <li>Configure API credentials before enabling any payment gateway</li>
                    <li>Use Sandbox mode for testing before going live</li>
                    <li>Enabled gateways will appear on the checkout page for customers</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
