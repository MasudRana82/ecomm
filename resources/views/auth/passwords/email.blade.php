@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Reset Password</h2>
                
                <p class="text-gray-600 text-center mb-6">Enter your email and we'll send you a link to reset your password.</p>
                
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email Address</label>
                        <input id="email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-orange @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="w-full bg-custom-orange text-white py-2 px-4 rounded-md hover:bg-custom-orange-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-orange">
                            Send Password Reset Link
                        </button>
                    </div>
                    
                    <div class="text-center">
                        <a class="text-sm text-custom-orange hover:text-orange-700" href="{{ route('login') }}">
                            Back to Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection