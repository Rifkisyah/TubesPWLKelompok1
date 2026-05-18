@extends('layouts.app')

@section('title', 'Edit User - JayMart')
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-2xl bg-white rounded-xl card-shadow p-6">
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
            <select name="role" required class="w-full border rounded-lg px-3 py-2">
                <option value="kasir" {{ $user->role === 'kasir' ? 'selected' : '' }}>Kasir</option>
                <option value="gudang" {{ $user->role === 'gudang' ? 'selected' : '' }}>Pegawai Gudang</option>
                <option value="supervisor" {{ $user->role === 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                <option value="manajer" {{ $user->role === 'manajer' ? 'selected' : '' }}>Manajer Toko</option>
                <option value="pemilik" {{ $user->role === 'pemilik' ? 'selected' : '' }}>Pemilik</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Cabang Toko</label>
            <select name="store_id" class="w-full border rounded-lg px-3 py-2">
                <option value="">- Tidak ada (Pemilik) -</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" {{ $user->store_id == $store->id ? 'selected' : '' }}>{{ $store->store_name }} - {{ $store->city }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update</button>
            <a href="{{ route('users.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
