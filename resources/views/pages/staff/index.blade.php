@extends('layouts.app')

@section('title', 'Kelola Staff - JayMart')
@section('page-title', 'Kelola Staff Cabang')
@section('page-subtitle', 'Manajemen kasir dan pegawai gudang')

@section('content')
<div class="bg-white rounded-xl card-shadow">
    <div class="p-6 border-b flex justify-between items-center rounded-t-xl sidebar-gradient">
        <h3 class="text-lg font-semibold text-white">Daftar Kasir & Pegawai Gudang</h3>
        <a href="{{ route('staff.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            <i class="fas fa-plus mr-1"></i> Tambah Staff
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">#</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Nama</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Email</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Jobdesk</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($staff as $index => $s)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm">{{ $staff->firstItem() + $index }}</td>
                    <td class="py-3 px-6 text-sm font-medium text-gray-800">{{ $s->name }}</td>
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $s->email }}</td>
                    <td class="py-3 px-6 text-sm">
                        @if($s->role === 'kasir')
                            <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded-full">Kasir</span>
                        @else
                            <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-2 py-1 rounded-full">Gudang</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-sm flex gap-2">
                        <a href="{{ route('messages.compose', ['to' => $s->id]) }}" class="text-blue-500 hover:text-blue-700" title="Kirim Pesan"><i class="fas fa-envelope"></i></a>
                        <a href="{{ route('staff.edit', $s) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit"><i class="fas fa-edit"></i></a>
                        <button type="button"
                                onclick="openDeleteModal('{{ route('staff.destroy', $s) }}')"
                                class="text-red-500 hover:text-red-700"
                                title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-8 text-center text-gray-400">Belum ada staff di cabang ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $staff->links() }}</div>
</div>
@endsection
