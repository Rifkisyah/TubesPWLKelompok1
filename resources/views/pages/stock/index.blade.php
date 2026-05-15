@extends('layouts.app')

@section('title', 'Stok Barang - JayMart')
@section('page-title', 'Stok Barang')
@section('page-subtitle', 'Monitoring stok produk')

@section('content')
<div class="bg-white rounded-xl card-shadow">
    <div class="p-6 border-b flex justify-between items-center rounded-t-xl sidebar-gradient">
        <h3 class="text-lg font-semibold text-white">Stok Produk</h3>
        <div class="flex gap-3">
            @if(in_array(auth()->user()->role, ['supervisor', 'gudang']))
            <a href="{{ route('stock.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
                <i class="fas fa-plus mr-1"></i> Catat Pergerakan
            </a>
            @else
            <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full self-center"><i class="fas fa-eye mr-1"></i> Mode Lihat Saja</span>
            @endif
            <a href="{{ route('stock.movements') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700">
                <i class="fas fa-history mr-1"></i> Riwayat
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">#</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Produk</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Kategori</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Cabang</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Stok</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($products as $index => $product)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm">{{ $products->firstItem() + $index }}</td>
                    <td class="py-3 px-6 text-sm font-medium text-gray-800">{{ $product->product_name }}</td>
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $product->category->category_name ?? '-' }}</td>
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $product->store->store_name ?? '-' }}</td>
                    <td class="py-3 px-6 text-sm font-semibold">{{ $product->stock }}</td>
                    <td class="py-3 px-6 text-sm">
                        @if($product->stock == 0)
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Habis</span>
                        @elseif($product->stock < 10)
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Rendah</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Aman</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="py-8 text-center text-gray-400">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $products->links() }}</div>
</div>
@endsection
