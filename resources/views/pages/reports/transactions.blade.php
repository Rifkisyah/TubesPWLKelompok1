@extends('layouts.app')

@section('title', 'Laporan Transaksi - JayMart')
@section('page-title', 'Laporan Transaksi')
@section('page-subtitle', 'Cetak laporan transaksi berdasarkan tanggal')

@section('content')
<div class="bg-white rounded-xl card-shadow">
    <div class="p-6 border-b rounded-t-xl sidebar-gradient">
        <form method="GET" class="flex gap-4 items-end flex-wrap justify-end">
            <div>
                <label class="block text-sm font-medium text-white mb-1">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="border rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-white mb-1">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="border rounded-lg px-3 py-2 text-sm">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 h-10">
                <i class="fas fa-search mr-1"></i> Tampilkan
            </button>
            @if(request('date_from') || request('date_to'))
            <button type="button" onclick="window.print()" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                <i class="fas fa-print mr-1"></i> Cetak
            </button>
            @endif
        </form>
    </div>

    @if(request('date_from') || request('date_to'))
    <div class="p-6 border-b bg-blue-50">
        <p class="text-sm text-gray-600">Total Pendapatan: <span class="font-bold text-lg text-blue-700">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span></p>
        <p class="text-sm text-gray-500">Jumlah Transaksi: {{ $transactions->count() }}</p>
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Invoice</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Kasir</th>
                    @if (auth()->user()->isOwner())
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Cabang</th>
                    @endif
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Total</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm font-medium text-blue-600">{{ $trx->invoice_number }}</td>
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $trx->user->name }}</td>
                    @if (auth()->user()->isOwner())
                        <td class="py-3 px-6 text-sm text-gray-700">{{ $trx->store->store_name }}</td>
                    @endif
                    <td class="py-3 px-6 text-sm font-semibold">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                    <td class="py-3 px-6 text-sm text-gray-500">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-8 text-center text-gray-400">Tidak ada data transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
