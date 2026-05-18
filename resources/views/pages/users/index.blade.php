@extends('layouts.app')

@section('title', 'Manajemen User - JayMart')
@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Kelola pengguna sistem')

@section('content')
<div class="bg-white rounded-xl card-shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">Daftar User</h3>
        <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            <i class="fas fa-plus mr-1"></i> Tambah User
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">#</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Nama</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Email</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Role</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Cabang</th>
                    <th class="text-left py-3 px-6 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($users as $index => $user)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm">{{ $users->firstItem() + $index }}</td>
                    <td class="py-3 px-6 text-sm font-medium text-gray-800">{{ $user->name }}</td>
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $user->email }}</td>
                    <td class="py-3 px-6 text-sm">
                        @php
                            $colors = ['pemilik' => 'bg-purple-100 text-purple-700', 'manajer' => 'bg-blue-100 text-blue-700', 'supervisor' => 'bg-yellow-100 text-yellow-700', 'kasir' => 'bg-green-100 text-green-700', 'gudang' => 'bg-gray-100 text-gray-700'];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $colors[$user->role] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="py-3 px-6 text-sm text-gray-600">{{ $user->store->store_name ?? '-' }}</td>
                    <td class="py-3 px-6 text-sm flex gap-2">
                        <a href="{{ route('users.edit', $user) }}" class="text-yellow-500 hover:text-yellow-700"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="py-8 text-center text-gray-400">Belum ada user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4">{{ $users->links() }}</div>
</div>
@endsection
