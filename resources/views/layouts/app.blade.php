<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FM Uniforms - One Brand. Every Professional.')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'fm-dark': '#051121',
                        'fm-gold': '#b78a46',
                        'fm-gold-hover': '#9b7337',
                        'fm-mediqo': '#08545e',
                        'fm-hostra': '#471d23',
                        'fm-workon': '#1b1b1b',
                        'fm-scholix': '#0b3254',
                        'fm-light': '#f8f9fc',
                        brand: {
                            navy: '#051121',
                            gold: '#b78a46',
                            mediqo: '#08545e',
                            hostra: '#471d23',
                            workon: '#1b1b1b',
                            scholix: '#0b3254',
                            light: '#f8f9fc',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                        'heading': ['Outfit', 'sans-serif'],
                    }
                }
            }
        };
    </script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@700;900&family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Custom CSS overrides -->
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    
    @yield('styles')
</head>
<body class="bg-white text-gray-800 antialiased font-sans flex flex-col min-h-screen">

    <!-- Header -->
    @include('layouts.header')

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Site Scripts -->
    <script src="{{ asset('js/index.js') }}"></script>
    @yield('scripts')
</body>
</html>
