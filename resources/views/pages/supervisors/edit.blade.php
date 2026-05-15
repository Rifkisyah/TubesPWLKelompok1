@extends('layouts.app')

@section('title', 'Edit Supervisor - JayMart')
@section('page-title', 'Edit Supervisor')

@section('content')
<div class="max-w-2xl bg-white rounded-xl card-shadow p-6">
    <form method="POST" action="{{ route('supervisors.update', $supervisor) }}">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', $supervisor->name) }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $supervisor->email) }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-gray-400">(kosongkan jika tidak diubah)</span></label>
            <input type="password" name="password" class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Perbarui</button>
            <a href="{{ route('supervisors.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
