@props(['background' => null])

@php
    $bgImage = $background 
        ?? config('app.auth_bg_image') 
        ?? env('AUTH_BG_IMAGE')
        ?? (file_exists(public_path('images/auth-bg.jpg')) ? asset('images/auth-bg.jpg') : null)
        ?? (file_exists(public_path('images/auth-bg.png')) ? asset('images/auth-bg.png') : null)
        ?? asset('images/auth-bg.svg');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RigStore') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 bg-slate-900">
        <!-- Customizable Background Container -->
        <div class="min-h-screen flex flex-col justify-between py-10 px-4 sm:px-6 lg:px-8 relative bg-cover bg-center bg-no-repeat"
             style="background-image: url('{{ $bgImage }}');">
            
            <!-- Dark Blur Overlay for readability -->
            <div class="absolute inset-0 bg-slate-950/65 backdrop-blur-[2px]"></div>

            <div class="relative z-10 w-full flex flex-col items-center justify-center flex-1">
                <!-- Branding Header -->
                <div class="mb-6 flex flex-col items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                        <div class="h-11 w-11 rounded-2xl bg-blue-600 border border-white/20 flex items-center justify-center shadow-lg shadow-blue-500/40 group-hover:scale-105 transition-transform duration-200">
                            <x-application-logo class="w-6 h-6 fill-current text-white" />
                        </div>
                        <span class="text-3xl font-extrabold tracking-tight text-white drop-shadow">
                            Rig<span class="text-blue-400">Store</span>
                        </span>
                    </a>
                    <p class="text-xs text-slate-300 mt-2 font-medium">Hardware & Rig Management Platform</p>
                </div>

                <!-- Auth Card -->
                <div class="w-full sm:max-w-md bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden p-7 sm:p-8">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer matching reference -->
            <footer class="relative z-10 mt-8 text-center text-xs text-white/70">
                <p>&copy; {{ date('Y') }} Rizal Co.</p>
            </footer>
        </div>
    </body>
</html>
