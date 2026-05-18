@extends('layouts.app')

@section('title', 'Tambah Kategori - JayMart')
@section('page-title', 'Tambah Kategori')

@section('content')
<div class="mt-60">
    <div class="max-w-full bg-white rounded-xl card-shadow p-6">
        <form method="POST" action="{{ route('categories.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="category_name" value="{{ old('category_name') }}" required class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="flex gap-3 justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
                <a href="{{ route('categories.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
