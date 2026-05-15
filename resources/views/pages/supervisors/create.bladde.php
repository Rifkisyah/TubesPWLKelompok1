@extends('layouts.app')

@section('title', 'Tambah Supervisor - JayMart')
@section('page-title', 'Tambah Supervisor')

@section('content')
<div class="max-w-2xl bg-white rounded-xl card-shadow p-6">
    <div class="mb-4 p-3 bg-blue-50 rounded-lg text-sm text-blue-700">
        <i class="fas fa-info-circle mr-1"></i> Supervisor akan ditambahkan ke cabang <strong>{{ $store->store_name }} - {{ $store->city }}</strong>
    </div>
    <form method="POST" action="{{ route('supervisors.store') }}">
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
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
            <a href="{{ route('supervisors.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
