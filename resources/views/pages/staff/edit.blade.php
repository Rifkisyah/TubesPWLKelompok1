@extends('layouts.app')

@section('title', 'Edit Staff - JayMart')
@section('page-title', 'Edit Staff Cabang')

@section('content')
<div class="mt-40">
    <div class="max-w-full bg-white rounded-xl card-shadow p-6">
        <form method="POST" action="{{ route('staff.update', $staff) }}">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $staff->name) }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $staff->email) }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-gray-400">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" required class="w-full border rounded-lg px-3 py-2">
                    <option value="kasir" {{ $staff->role === 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="gudang" {{ $staff->role === 'gudang' ? 'selected' : '' }}>Pegawai Gudang</option>
                </select>
            </div>
            <div class="flex gap-3 justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Perbarui</button>
                <a href="{{ route('staff.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
