@extends('layouts.app')

@section('title', 'Laporan Stok - JayMart')
@section('page-title', 'Laporan Stok')
@section('page-subtitle', 'Cetak laporan pergerakan stok berdasarkan tanggal')

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

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Produk</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Tipe</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Jumlah</th>
                    @if (auth()->user()->isOwner())
                        <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Cabang</th>
                    @endif
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Petugas</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($movements as $movement)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm text-gray-500">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                    <td class="py-3 px-6 text-sm font-medium text-gray-800">{{ $movement->product->product_name }}</td>
                    <td class="py-3 px-6 text-sm">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $movement->type === 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($movement->type) }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-sm font-semibold">{{ $movement->quantity }}</td>
                    @if (auth()->user()->isOwner())
                        <td class="py-3 px-6 text-sm text-gray-600">{{ $movement->store->store_name }}</td>
                    @endif
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $movement->user->name }}</td>
                    <td class="py-3 px-6 text-sm text-gray-500">{{ $movement->description ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="py-8 text-center text-gray-400">Tidak ada data pergerakan stok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
