@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Reset Password</h2>
                
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                        <input id="email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-orange @error('email') border-red-500 @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 text-sm font-medium mb-2">New Password</label>
                        <input id="password" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-orange @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="block text-gray-700 text-sm font-medium mb-2">Confirm New Password</label>
                        <input id="password-confirm" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-orange" name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="w-full bg-custom-orange text-white py-2 px-4 rounded-md hover:bg-custom-orange-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-orange">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection