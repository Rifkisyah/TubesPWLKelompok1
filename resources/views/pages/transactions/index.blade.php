@extends('layouts.app')

@section('title', 'Transaksi - JayMart')
@section('page-title', 'Transaksi')
@section('page-subtitle', 'Daftar semua transaksi')

@section('content')
<div class="bg-white rounded-xl card-shadow">
    <div class="p-6 border-b flex flex-col md:flex-row justify-between items-start md:items-center gap-4 rounded-t-xl sidebar-gradient">
        <h3 class="text-lg font-semibold text-white">Riwayat Transaksi</h3>
        <div class="flex gap-3 items-center flex-wrap">
            <form method="GET" class="flex gap-2 items-center">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="border rounded-lg px-3 py-2 text-sm">
                <span class="text-gray-400">-</span>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="border rounded-lg px-3 py-2 text-sm">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 h-10">Filter</button>
            </form>
            @if(in_array(auth()->user()->role, ['kasir', 'supervisor']))
            <a href="{{ route('transactions.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 h-10">
                <i class="fas fa-plus mr-1"></i> Transaksi Baru
            </a>
            @else
            <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full"><i class="fas fa-eye mr-1"></i> Mode Lihat Saja</span>
            @endif
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">No. Invoice</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Kasir</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Cabang</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Total</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm font-medium text-blue-600">{{ $trx->invoice_number }}</td>
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $trx->user->name }}</td>
                    <td class="py-3 px-6 text-sm text-gray-700">{{ $trx->store->store_name }}</td>
                    <td class="py-3 px-6 text-sm font-semibold text-gray-800">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                    <td class="py-3 px-6 text-sm text-gray-500">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td class="py-3 px-6">
                        <a href="{{ route('transactions.show', $trx) }}" class="text-blue-500 hover:text-blue-700 text-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-400">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $transactions->links() }}</div>
</div>
@endsection
