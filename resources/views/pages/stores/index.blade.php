@extends('layouts.app')

@section('title', 'Cabang Toko - JayMart')
@section('page-title', 'Cabang Toko')
@section('page-subtitle', 'Kelola cabang mini market')

@section('content')
<div class="bg-white rounded-xl card-shadow">
    <div class="p-6 border-b flex justify-between items-center rounded-t-xl sidebar-gradient">
        <h3 class="text-lg font-semibold text-white">Daftar Cabang</h3>
        <a href="{{ route('stores.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            <i class="fas fa-plus mr-1"></i> Tambah Cabang
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">#</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Nama Toko</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Kota</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Telepon</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Pegawai</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Produk</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Transaksi</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($stores as $index => $store)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm">{{ $stores->firstItem() + $index }}</td>
                    <td class="py-3 px-6 text-sm font-medium text-gray-800">{{ $store->store_name }}</td>
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $store->city }}</td>
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $store->phone ?? '-' }}</td>
                    <td class="py-3 px-6 text-sm">{{ $store->users_count }}</td>
                    <td class="py-3 px-6 text-sm">{{ $store->products_count }}</td>
                    <td class="py-3 px-6 text-sm">{{ $store->transactions_count }}</td>
                    <td class="py-3 px-6 text-sm flex gap-2">
                        <a href="{{ route('stores.edit', $store) }}" class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-edit"></i></a>
                        <button type="button"
                                onclick="openDeleteModal('{{ route('stores.destroy', $store) }}')"
                                class="text-red-500 hover:text-red-700"
                                title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="py-8 text-center text-gray-400">Belum ada cabang.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $stores->links() }}</div>
</div>
@endsection
