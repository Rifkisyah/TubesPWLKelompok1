@extends('layouts.app')

@section('title', 'Tambah User - JayMart')
@section('page-title', 'Tambah User')

@section('content')
<div class="max-w-2xl bg-white rounded-xl card-shadow p-6">
    <form method="POST" action="{{ route('users.store') }}">
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
                <option value="kasir">Kasir</option>
                <option value="gudang">Pegawai Gudang</option>
                <option value="supervisor">Supervisor</option>
                <option value="manajer">Manajer Toko</option>
                <option value="pemilik">Pemilik</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Cabang Toko</label>
            <select name="store_id" class="w-full border rounded-lg px-3 py-2">
                <option value="">- Tidak ada (Pemilik) -</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}">{{ $store->store_name }} - {{ $store->city }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <a href="{{ route('users.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
