@extends('layouts.app')

@section('title', 'Dashboard - JayMart')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data toko')

@section('content')

{{-- Integrity Alert for Owner --}}
@if(auth()->user()->isOwner() && isset($integrityAlerts) && $integrityAlerts->count() > 0)
<div class="mb-6 p-4 bg-red-50 border-2 border-red-400 rounded-xl flex items-start gap-4">
    <div class="w-12 h-12 flex-shrink-0 bg-red-100 rounded-full flex items-center justify-center">
        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
    </div>
    <div class="flex-1">
        <p class="font-bold text-red-700">⚠ Peringatan: {{ $integrityAlerts->count() }} Ketidaksesuaian Data Terdeteksi!</p>
        <p class="text-red-600 text-sm mt-1">Ditemukan produk dengan stok yang tidak sinkron antara catatan dan perhitungan aktual. Bisa jadi ada manipulasi data.</p>
        <a href="{{ route('reports.integrity') }}" class="mt-2 inline-block bg-red-600 text-white text-sm px-4 py-1.5 rounded-lg hover:bg-red-700">
            <i class="fas fa-shield-alt mr-1"></i> Lihat Laporan Integritas
        </a>
    </div>
</div>
@endif

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Transaksi</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalTransactions) }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-receipt text-blue-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Pendapatan</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-green-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Produk</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalProducts) }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-box text-purple-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl p-6 card-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Stok Rendah</p>
                <p class="text-2xl font-bold {{ $lowStock > 0 ? 'text-red-600' : 'text-gray-800' }} mt-1">{{ number_format($lowStock) }}</p>
            </div>
            <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

{{-- Unread Messages Banner --}}
@if(isset($unreadMessages) && $unreadMessages > 0)
<div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-center justify-between">
    <div class="flex items-center gap-3">
        <i class="fas fa-envelope text-blue-500 text-lg"></i>
        <p class="text-blue-700 text-sm">Anda memiliki <strong>{{ $unreadMessages }} pesan belum dibaca</strong></p>
    </div>
    <a href="{{ route('messages.inbox') }}" class="text-blue-600 text-sm font-medium hover:underline">Buka Kotak Masuk →</a>
</div>
@endif

@php
    $gridcols = auth()->user()->isOwner() ? 'grid-cols-1 md:grid-cols-2' : 'grid-cols-1';
    $canvasHeight = auth()->user()->isOwner() ? 200 : 100;
@endphp

<div class="grid grid-cols-1 {{ $gridcols }} gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 card-shadow cols-2">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pendapatan Bulanan</h3>
        <canvas id="revenueChart" height="{{ $canvasHeight }}"></canvas>
    </div>

    @if (auth()->user()->isOwner())
        <div class="bg-white rounded-xl p-6 card-shadow">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Data Cabang</h3>
                @if(auth()->user()->isOwner())
                <a href="{{ route('reports.revenue') }}" class="text-blue-500 text-xs hover:underline">Laporan Lengkap →</a>
                @endif
            </div>
            <div class="space-y-3">
                @foreach($stores as $store)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-800">{{ $store->store_name }}</p>
                        <p class="text-sm text-gray-500">{{ $store->city }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-600">{{ $store->transactions_count }} transaksi</p>
                        <p class="text-sm text-gray-500">{{ $store->products_count }} produk</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    const revenueData = @json($monthlyRevenue);

    const labels = revenueData.map(r => months[r.month - 1]);
    const data = revenueData.map(r => r.total);

    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: data,
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID') } }
            },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endpush
