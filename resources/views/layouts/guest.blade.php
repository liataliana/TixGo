<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TixGo') }}</title>

        <!-- Fonts (Poppins untuk tampilan modern) -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="font-family: 'Poppins', sans-serif; background-color: #f5f7fa; margin: 0; color: #0f172a;">
        
        <div style="min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 16px;">
            
            <!-- Logo TixGo yang Elegan -->
            <div style="margin-bottom: 32px; display: flex; align-items: center; gap: 12px; cursor: pointer;" onclick="window.location='/'">
                <div style="width: 48px; height: 48px; background-color: #0066ff; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0, 102, 255, 0.2);">
                    <i class="fa-solid fa-ticket" style="color: white; font-size: 24px; transform: rotate(12deg);"></i>
                </div>
                <div>
                    <h1 style="font-size: 24px; font-weight: 800; margin: 0; letter-spacing: -0.5px; color: #0f172a;">Tix<span style="color: #0066ff;">Go</span></h1>
                    <p style="font-size: 10px; color: #94a3b8; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin: -4px 0 0 0;">E-Ticketing System</p>
                </div>
            </div>

            <!-- Card Auth (Login/Register) Traveloka Style -->
            <div style="width: 100%; max-width: 420px; background-color: white; border-radius: 16px; padding: 32px; border: 1px solid rgba(229, 231, 235, 0.8); box-shadow: 0 8px 30px rgba(0,0,0,0.04); position: relative; overflow: hidden;">
                
                <!-- Dekorasi Garis Biru Tipis di Atas Card -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: linear-gradient(to right, #0066ff, #00d4ff);"></div>
                @yield('content')
                
            </div>

            <!-- Footer Text -->
            <div style="margin-top: 32px; text-align: center;">
                <p style="font-size: 12px; color: #94a3b8; font-weight: 500; margin: 0;">© 2026 TixGo. All rights reserved.</p>
            </div>

        </div>
    </body>
</html>