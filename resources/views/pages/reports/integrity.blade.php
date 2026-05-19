@extends('layouts.app')

@section('title', 'Integritas Data - JayMart')
@section('page-title', 'Laporan Integritas Data')
@section('page-subtitle', 'Deteksi ketidaksesuaian stok dan potensi manipulasi data')

@section('content')

@if($suspiciousCount > 0)
<div class="mb-6 p-4 bg-red-50 border-2 border-red-300 rounded-xl flex items-start gap-4">
    <div class="w-12 h-12 flex-shrink-0 bg-red-100 rounded-full flex items-center justify-center">
        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
    </div>
    <div>
        <p class="font-bold text-red-700 text-lg">⚠ PERINGATAN: Ditemukan {{ $suspiciousCount }} Ketidaksesuaian Data!</p>
        <p class="text-red-600 text-sm mt-1">Terdapat produk dengan stok tercatat yang tidak sesuai dengan perhitungan berdasarkan riwayat pergerakan dan transaksi. Hal ini dapat mengindikasikan adanya manipulasi data oleh pegawai.</p>
    </div>
</div>
@else
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-4">
    <i class="fas fa-check-circle text-green-500 text-2xl"></i>
    <p class="text-green-700 font-medium">Semua data stok dalam kondisi normal. Tidak ada ketidaksesuaian yang ditemukan.</p>
</div>
@endif

<div class="bg-white rounded-xl card-shadow overflow-hidden">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Rincian Integritas Stok Per Produk</h3>
        <div class="flex gap-2 text-xs">
            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full"><i class="fas fa-check mr-1"></i>Normal</span>
            <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full"><i class="fas fa-exclamation mr-1"></i>Tidak Sesuai</span>
        </div>
    </div>

    <div class="p-4 bg-blue-50 border-b text-xs text-blue-700">
        <i class="fas fa-info-circle mr-1"></i>
        <strong>Rumus:</strong> Stok Teoritis = (Total Masuk) − (Total Keluar Manual) − (Total Terjual via Transaksi). Jika Stok Tercatat ≠ Stok Teoritis, maka ada indikasi manipulasi.
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Produk</th>
                    <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Cabang</th>
                    <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Masuk</th>
                    <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Keluar</th>
                    <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Terjual</th>
                    <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Stok Teoritis</th>
                    <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Stok Tercatat</th>
                    <th class="text-right py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Selisih</th>
                    <th class="text-center py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($alerts as $alert)
                <tr class="{{ $alert['is_suspicious'] ? 'bg-red-50 hover:bg-red-100' : 'hover:bg-gray-50' }}">
                    <td class="py-3 px-4">
                        <p class="font-medium text-gray-800 text-sm">{{ $alert['product']->product_name }}</p>
                        <p class="text-xs text-gray-500">{{ $alert['product']->category->category_name ?? '-' }}</p>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $alert['product']->store->store_name ?? '-' }}</td>
                    <td class="py-3 px-4 text-right text-sm text-green-700 font-medium">+{{ number_format($alert['stock_in']) }}</td>
                    <td class="py-3 px-4 text-right text-sm text-orange-600 font-medium">-{{ number_format($alert['stock_out']) }}</td>
                    <td class="py-3 px-4 text-right text-sm text-blue-600 font-medium">-{{ number_format($alert['sold']) }}</td>
                    <td class="py-3 px-4 text-right text-sm font-semibold text-gray-700">{{ number_format($alert['calculated_stock']) }}</td>
                    <td class="py-3 px-4 text-right text-sm font-semibold text-gray-900">{{ number_format($alert['recorded_stock']) }}</td>
                    <td class="py-3 px-4 text-right">
                        @if($alert['discrepancy'] != 0)
                            <span class="font-bold text-red-700 text-sm">{{ $alert['discrepancy'] > 0 ? '+' : '' }}{{ number_format($alert['discrepancy']) }}</span>
                        @else
                            <span class="text-green-600 text-sm">0</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-center">
                        @if($alert['is_suspicious'])
                            <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full">
                                <i class="fas fa-exclamation-triangle"></i> RISIKO
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded-full">
                                <i class="fas fa-check"></i> Normal
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 
