@extends('layouts.app')

@section('title', 'Kategori - JayMart')
@section('page-title', 'Kategori Produk')
@section('page-subtitle', 'Kelola kategori produk')

@section('content')
<div class="bg-white rounded-xl card-shadow">
    <div class="p-6 border-b flex justify-between items-center rounded-t-xl sidebar-gradient">
        <h3 class="text-lg font-semibold text-white">Daftar Kategori</h3>
        @if(auth()->user()->isSupervisor())
        <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            <i class="fas fa-plus mr-1"></i> Tambah Kategori
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
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Nama Kategori</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Jumlah Produk</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($categories as $index => $category)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm">{{ $categories->firstItem() + $index }}</td>
                    <td class="py-3 px-6 text-sm font-medium text-gray-800">{{ $category->category_name }}</td>
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $category->products_count }}</td>
                    <td class="py-3 px-6 text-sm">
                        <div class="flex gap-2">
                            @if(auth()->user()->isSupervisor())
                            <a href="{{ route('categories.edit', $category) }}" class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-edit"></i></a>
                            <button type="button"
                                    onclick="openDeleteModal('{{ route('categories.destroy', $category) }}')"
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
                <tr><td colspan="4" class="py-8 text-center text-gray-400">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $categories->links() }}</div>
</div>
@endsection
