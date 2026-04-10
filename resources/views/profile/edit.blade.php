@extends('layouts.app')

@section('title', 'My Profile')
@section('content')

<!-- Page Title -->
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">My Profile</h1>
    <p class="text-sm text-gray-500 mt-1">Manage your account information</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Sidebar -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden sticky top-6">
            <div class="p-6 text-center border-b border-gray-100">
                <div class="w-24 h-24 mx-auto bg-gradient-to-br from-gray-800 to-gray-700 rounded-full flex items-center justify-center shadow-lg">
                    <span class="text-3xl font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <h2 class="text-lg font-semibold text-gray-800 mt-3">{{ Auth::user()->name }}</h2>
                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                <p class="text-xs text-gray-400 mt-2">Member since {{ Auth::user()->created_at->format('F Y') }}</p>
            </div>
            <div class="p-4 space-y-1">
                <div class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 bg-gray-50 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Personal Information</span>
                </div>
                <div class="flex items-center gap-3 px-3 py-2 text-sm text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>Security</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Edit Profile Form -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Edit Profile</h3>
                <p class="text-xs text-gray-500 mt-0.5">Update your personal information</p>
            </div>
            
            <form method="POST" action="{{ route('profile.update') }}" class="p-6">
                @csrf
                @method('patch')
                
                <div class="space-y-5">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                               class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors @error('name') border-red-500 @enderror"
                               required>
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors @error('email') border-red-500 @enderror"
                               required>
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Form -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800">Change Password</h3>
                <p class="text-xs text-gray-500 mt-0.5">Update your password</p>
            </div>
            
            <form method="POST" action="{{ route('password.update') }}" class="p-6">
                @csrf
                @method('put')
                
                <div class="space-y-5">
                    <!-- Current Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Current Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="current_password" 
                               class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors @error('current_password') border-red-500 @enderror"
                               required>
                        @error('current_password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- New Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" 
                               class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors @error('password') border-red-500 @enderror"
                               required>
                        <p class="text-xs text-gray-400 mt-1">Minimum 8 characters</p>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Confirm New Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Confirm New Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" 
                               class="w-full px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 transition-colors"
                               required>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-colors">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Account Section -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-red-600">Delete Account</h3>
                <p class="text-xs text-gray-500 mt-0.5">Permanently delete your account</p>
            </div>
            
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">
                    Once your account is deleted, all of its resources and data will be permanently deleted.
                </p>
                
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" 
                               class="w-full max-w-sm px-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-red-400 focus:border-red-400 transition-colors"
                               placeholder="Enter your password to confirm">
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors"
                            onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone!')">
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection