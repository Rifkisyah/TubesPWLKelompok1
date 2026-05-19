<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JayMart - Sistem Manajemen')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .sidebar-gradient { background: linear-gradient(180deg, #1e3a5f 0%, #0f2744 100%); }
        .nav-active { background: rgba(255,255,255,0.15); border-left: 3px solid #38bdf8; }
        .nav-hover:hover { background: rgba(255,255,255,0.1); }
        .card-shadow { box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 1px 2px rgba(0,0,0,0.06); }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col ml-64">
            @include('layouts.header')

            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')
            </main>

            <footer class="bg-white border-t px-6 py-4 text-sm text-gray-500 flex justify-between">
                <span>&copy; 2026 JayMart - Sistem Manajemen Mini Market</span>
                <span>Kelompok 1 - PWL</span>
            </footer>
        </div>
    </div>
    @stack('scripts')
    <x-delete-modal />
</body>
</html>
