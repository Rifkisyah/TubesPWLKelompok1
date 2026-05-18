@extends('layouts.app')

@section('title', 'Produk - JayMart')
@section('page-title', 'Produk')
@section('page-subtitle', 'Daftar semua produk')

@section('content')
<div class="bg-white rounded-xl card-shadow">
    <div class="p-6 border-b flex justify-between items-center rounded-t-xl sidebar-gradient">
        <h3 class="text-lg font-semibold text-white">Daftar Produk</h3>
        @if(in_array(auth()->user()->role, ['supervisor', 'gudang']))
        <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            <i class="fas fa-plus mr-1"></i> Tambah Produk
        </a>
        @else
        <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full"><i class="fas fa-eye mr-1"></i> Mode Lihat Saja</span>
        @endif
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">#</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Nama Produk</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Kategori</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Harga</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Stok</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Cabang</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($products as $index => $product)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm">{{ $products->firstItem() + $index }}</td>
                    <td class="py-3 px-6 text-sm font-medium text-gray-800">{{ $product->product_name }}</td>
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $product->category->category_name ?? '-' }}</td>
                    <td class="py-3 px-6 text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="py-3 px-6 text-sm">
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $product->stock < 10 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $product->store->store_name ?? '-' }}</td>
                    <td class="py-3 px-6 text-sm">
                        <div class="flex gap-2">
                            @if(in_array(auth()->user()->role, ['supervisor', 'gudang']))
                            <a href="{{ route('products.edit', $product) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit"><i class="fas fa-edit"></i></a>
                            <button type="button"
                                    onclick="openDeleteModal('{{ route('products.destroy', $product) }}')"
                                    class="text-red-500 hover:text-red-700"
                                    title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button> 
                            @else
                            <span class="text-gray-400 text-xs">—</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="py-8 text-center text-gray-400">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $products->links() }}</div>
</div>
@endsection
