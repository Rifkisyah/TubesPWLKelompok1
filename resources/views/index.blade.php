@extends('layouts.landing-page')

@section('title', 'JayMart - Sistem Manajemen Mini Market')

@section('content')

<section class="py-24 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 text-white text-center">
    <div class="max-w-3xl mx-auto px-6">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Kelola Mini Market Anda dari Mana Saja</h1>
        <p class="text-blue-200 text-lg mb-8">Sistem manajemen terpadu untuk memantau transaksi dan stok barang di seluruh cabang dalam satu platform.</p>
        <a href="{{ route('login') }}" class="inline-block bg-white text-blue-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
            <i class="fas fa-sign-in-alt mr-2"></i>Mulai Sekarang
        </a>
    </div>
</section>

<section id="features" class="py-20 px-8 max-w-6xl mx-auto">
    <h2 class="text-3xl font-bold text-center mb-4 text-gray-800">Fitur Utama</h2>
    <p class="text-center text-gray-500 mb-12">Solusi lengkap untuk manajemen mini market multi-cabang</p>

    <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border hover:shadow-md transition">
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mb-4">
                <i class="fas fa-building text-blue-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-lg mb-2">Multi Cabang</h3>
            <p class="text-gray-500">Kelola 5 cabang mini market dari satu dashboard terpusat.</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border hover:shadow-md transition">
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center mb-4">
                <i class="fas fa-cash-register text-green-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-lg mb-2">Transaksi Real-time</h3>
            <p class="text-gray-500">Pantau setiap transaksi yang terjadi di semua cabang secara langsung.</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border hover:shadow-md transition">
            <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center mb-4">
                <i class="fas fa-warehouse text-purple-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-lg mb-2">Manajemen Stok</h3>
            <p class="text-gray-500">Kontrol keluar masuk barang dengan pencatatan yang transparan.</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border hover:shadow-md transition">
            <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center mb-4">
                <i class="fas fa-users-cog text-yellow-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-lg mb-2">Role-Based Access</h3>
            <p class="text-gray-500">Hak akses berbeda untuk Pemilik, Manajer, Supervisor, Kasir, dan Gudang.</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border hover:shadow-md transition">
            <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center mb-4">
                <i class="fas fa-file-invoice-dollar text-red-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-lg mb-2">Laporan & Cetak</h3>
            <p class="text-gray-500">Cetak laporan transaksi dan stok berdasarkan rentang tanggal.</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border hover:shadow-md transition">
            <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center mb-4">
                <i class="fas fa-shield-alt text-indigo-600 text-xl"></i>
            </div>
            <h3 class="font-semibold text-lg mb-2">Pengawasan Terpusat</h3>
            <p class="text-gray-500">Cegah manipulasi data dengan sistem pengawasan yang ketat.</p>
        </div>
    </div>
</section>

<section id="about" class="py-20 px-8 bg-gray-100">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-4 text-gray-800">Tim Pengembang</h2>
        <p class="text-gray-500 mb-10">Kelompok 1 - Pemrograman Web Lanjut</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user text-blue-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Rifki Syahdan Prasetyo</h3>
                <p class="text-sm text-gray-500 mt-1">5520123107</p>
                <p class="text-xs text-blue-600 mt-2">Backend</p>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user text-green-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Nabila Hunafa Tresnawati</h3>
                <p class="text-sm text-gray-500 mt-1">5520123103</p>
                <p class="text-xs text-green-600 mt-2">Frontend & UI/UX</p>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user text-purple-600 text-xl"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Radhia Majdi Syadzwan</h3>
                <p class="text-sm text-gray-500 mt-1">5520124148</p>
                <p class="text-xs text-purple-600 mt-2">Database</p>
            </div>
        </div>
    </div>
</section>

@endsection
