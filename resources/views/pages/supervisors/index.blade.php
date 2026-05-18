@extends('layouts.app')

@section('title', 'Kelola Supervisor - JayMart')
@section('page-title', 'Kelola Supervisor')
@section('page-subtitle', 'Manajemen supervisor cabang {{ auth()->user()->store->store_name ?? "" }}')

@section('content')
<div class="bg-white rounded-xl card-shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Daftar Supervisor Cabang</h3>
        <a href="{{ route('supervisors.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            <i class="fas fa-plus mr-1"></i> Tambah Supervisor
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">#</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Nama</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Email</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Cabang</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($supervisors as $index => $sv)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm">{{ $supervisors->firstItem() + $index }}</td>
                    <td class="py-3 px-6 text-sm font-medium text-gray-800">{{ $sv->name }}</td>
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $sv->email }}</td>
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $sv->store->store_name ?? '-' }}</td>
                    <td class="py-3 px-6 text-sm flex gap-2">
                        <a href="{{ route('messages.compose', ['to' => $sv->id]) }}" class="text-blue-500 hover:text-blue-700" title="Kirim Pesan"><i class="fas fa-envelope"></i></a>
                        <a href="{{ route('supervisors.edit', $sv) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('supervisors.destroy', $sv) }}" method="POST" onsubmit="return confirm('Hapus supervisor ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-8 text-center text-gray-400">Belum ada supervisor di cabang ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $supervisors->links() }}</div>
</div>
@endsection
