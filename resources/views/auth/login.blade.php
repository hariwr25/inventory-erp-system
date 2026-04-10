<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Inventaris</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left Side - Corporate Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-gray-900 relative overflow-hidden">
            <!-- Abstract Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="absolute top-0 left-0 w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-between p-12 h-full">
                <div>
                    <div class="flex items-center gap-2 mb-20">
                        <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0l-4-4m4 4H4m8 4v4" />
                            </svg>
                        </div>
                        <span class="text-xl font-semibold text-white tracking-tight">Inventaris</span>
                    </div>
                    
                    <div class="space-y-4">
                        <h1 class="text-4xl font-bold text-white leading-tight">
                            Inventory Management<br>
                            <span class="text-gray-400">for modern businesses</span>
                        </h1>
                        <p class="text-gray-400 text-base leading-relaxed max-w-md">
                            Streamline your stock operations with real-time tracking, automated alerts, and comprehensive reporting.
                        </p>
                    </div>
                </div>
                
                <!-- Testimonial -->
                <div class="border-t border-gray-800 pt-6">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-gray-700 border-2 border-gray-900"></div>
                            <div class="w-8 h-8 rounded-full bg-gray-700 border-2 border-gray-900"></div>
                            <div class="w-8 h-8 rounded-full bg-gray-700 border-2 border-gray-900"></div>
                        </div>
                        <p class="text-sm text-gray-500">Trusted by 10,000+ businesses worldwide</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-sm">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <div class="inline-flex items-center justify-center w-10 h-10 bg-gray-900 rounded-lg mb-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7v10a2 2 0 01-2 2H6a2 2 0 01-2-2V7m16 0l-4-4m4 4H4m8 4v4" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Welcome back</h2>
                </div>

                <!-- Form Header -->
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-900">Sign in</h2>
                    <p class="text-sm text-gray-500 mt-1">Enter your credentials to access your account</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email address
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full px-4 py-2.5 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                               placeholder="name@company.com">
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-sm font-medium text-gray-700">
                                Password
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-gray-500 hover:text-gray-700 transition">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required
                               class="w-full px-4 py-2.5 text-sm bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                               placeholder="Enter your password">
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mb-8">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-gray-900 focus:ring-gray-900">
                            <span class="ms-2 text-sm text-gray-600">Keep me signed in</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full py-2.5 text-sm font-medium text-white bg-gray-900 rounded-lg hover:bg-gray-800 transition-all">
                        Sign in
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-gray-900 hover:text-gray-700 font-medium">
                            Create an account
                        </a>
                    </p>
                </div>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-white text-gray-400">Secure access</span>
                    </div>
                </div>

                <!-- Trust Badge -->
                <div class="text-center">
                    <div class="flex items-center justify-center gap-4 text-xs text-gray-400">
                        <span>🔒 SSL Encrypted</span>
                        <span>✓ GDPR Compliant</span>
                        <span>🛡️ 2FA Ready</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>