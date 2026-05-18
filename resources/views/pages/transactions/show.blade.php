@extends('layouts.app')

@section('title', 'Detail Transaksi - JayMart')
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', $transaction->invoice_number)

@section('content')
<div class="bg-white rounded-xl card-shadow p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h3 class="text-xl font-bold text-gray-800">{{ $transaction->invoice_number }}</h3>
            <p class="text-sm text-gray-500 mt-1">{{ $transaction->created_at->format('d F Y, H:i') }}</p>
        </div>
        <a href="{{ route('transactions.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
        <div>
            <p class="text-xs text-gray-500">Kasir</p>
            <p class="font-medium text-gray-800">{{ $transaction->user->name }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Cabang</p>
            <p class="font-medium text-gray-800">{{ $transaction->store->store_name }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Kota</p>
            <p class="font-medium text-gray-800">{{ $transaction->store->city }}</p>
        </div>
    </div>

    <table class="w-full mb-6">
        <thead class="bg-gray-50">
            <tr>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Produk</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Harga</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Qty</th>
                <th class="text-left py-3 px-4 text-xs font-semibold text-gray-500 uppercase">Subtotal</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($transaction->items as $item)
            <tr>
                <td class="py-3 px-4 text-sm">{{ $item->product->product_name }}</td>
                <td class="py-3 px-4 text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="py-3 px-4 text-sm">{{ $item->quantity }}</td>
                <td class="py-3 px-4 text-sm font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="border-t pt-4 space-y-2">
        <div class="flex justify-between">
            <span class="text-gray-600">Total</span>
            <span class="font-bold text-lg">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-600">Bayar</span>
            <span class="font-medium">Rp {{ number_format($transaction->payment_amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-600">Kembalian</span>
            <span class="font-medium text-green-600">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
@endsection
