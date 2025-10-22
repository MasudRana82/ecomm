@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">Contact Us</h1>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Contact Information -->
            <div class="bg-gray-50 rounded-lg p-8 shadow-sm">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Get in Touch</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-custom-orange flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Address</h3>
                            <p class="text-gray-600">123 Main Street, Dhaka, Bangladesh</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-custom-orange flex items-center justify-center">
                            <i class="fas fa-phone-alt text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Phone</h3>
                            <p class="text-gray-600">+880 123 456 7890</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-custom-orange flex items-center justify-center">
                            <i class="fas fa-envelope text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Email</h3>
                            <p class="text-gray-600">support@ghorerbazar.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-custom-orange flex items-center justify-center">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Business Hours</h3>
                            <p class="text-gray-600">Monday - Friday: 9:00 AM - 6:00 PM</p>
                            <p class="text-gray-600">Saturday: 10:00 AM - 4:00 PM</p>
                            <p class="text-gray-600">Sunday: Closed</p>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center hover:bg-custom-orange hover:text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center hover:bg-custom-orange hover:text-white transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center hover:bg-custom-orange hover:text-white transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="bg-gray-50 rounded-lg p-8 shadow-sm">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Send Us a Message</h2>
                
                <form>
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
                        <input type="text" id="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-orange" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                        <input type="email" id="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-orange" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="subject" class="block text-gray-700 font-medium mb-2">Subject</label>
                        <input type="text" id="subject" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-orange" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="message" class="block text-gray-700 font-medium mb-2">Message</label>
                        <textarea id="message" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-orange" required></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-custom-orange text-white py-2 px-4 rounded-md hover:bg-custom-orange-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-orange">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection