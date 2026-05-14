<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JayMart')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <nav class="flex justify-between items-center px-8 py-4 bg-white shadow-sm sticky top-0 z-50">
        <h1 class="font-bold text-xl text-blue-900">
            <i class="fas fa-store mr-2"></i>JayMart
        </h1>
        <div class="space-x-6">
            <a href="#features" class="text-gray-600 hover:text-blue-600 transition">Fitur</a>
            <a href="#about" class="text-gray-600 hover:text-blue-600 transition">Tentang</a>
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">Login</a>
        </div>
    </nav>

    @yield('content')

    <footer class="text-center py-8 bg-white border-t">
        <p class="text-sm text-gray-500">&copy; 2026 JayMart - Sistem Manajemen Mini Market | Kelompok 1 PWL</p>
    </footer>
</body>
</html>
