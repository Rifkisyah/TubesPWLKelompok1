@extends('layouts.app')

@section('title', 'Tambah Staff - JayMart')
@section('page-title', 'Tambah Staff Cabang')

@section('content')
<div class="mt-40">
    <div class="max-w-full bg-white rounded-xl card-shadow p-6">
        <div class="mb-4 p-3 bg-blue-50 rounded-lg text-sm text-blue-700">
            <i class="fas fa-info-circle mr-1"></i> Staff akan ditambahkan ke cabang <strong>{{ $store->store_name }} - {{ $store->city }}</strong>
        </div>
        <form method="POST" action="{{ route('staff.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" required class="w-full border rounded-lg px-3 py-2">
                    <option value="kasir" {{ old('role') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="gudang" {{ old('role') === 'gudang' ? 'selected' : '' }}>Pegawai Gudang</option>
                </select>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
                <a href="{{ route('staff.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
