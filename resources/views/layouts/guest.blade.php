<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            font-family: 'Figtree', system-ui, -apple-system, sans-serif;
        }
        .guest-shell {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #FFF7ED 0%, #FFEDD5 50%, #FED7AA 100%);
            padding: 24px;
            position: relative;
            overflow: hidden;
        }
        /* dekorasi bulatan oranye samar di background */
        .guest-shell::before,
        .guest-shell::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .35;
            pointer-events: none;
        }
        .guest-shell::before {
            width: 320px; height: 320px;
            background: #FB923C;
            top: -80px; left: -80px;
        }
        .guest-shell::after {
            width: 380px; height: 380px;
            background: #F97316;
            bottom: -100px; right: -100px;
        }
        .guest-slot {
            position: relative;
            z-index: 1;
            width: 100%;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="guest-shell">
        <div class="guest-slot">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
