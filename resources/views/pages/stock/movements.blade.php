@extends('layouts.app')

@section('title', 'Riwayat Pergerakan Stok - JayMart')
@section('page-title', 'Riwayat Pergerakan Stok')

@section('content')
<div class="bg-white rounded-xl card-shadow">
    <div class="p-6 border-b flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h3 class="text-lg font-semibold text-gray-800">Riwayat Stok</h3>
        <form method="GET" class="flex gap-2 items-center">
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="border rounded-lg px-3 py-2 text-sm">
            <span class="text-gray-400">-</span>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="border rounded-lg px-3 py-2 text-sm">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">Filter</button>
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
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $movement->user->name }}</td>
                    <td class="py-3 px-6 text-sm text-gray-500">{{ $movement->description ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="py-8 text-center text-gray-400">Belum ada riwayat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $movements->links() }}</div>
</div>
@endsection
