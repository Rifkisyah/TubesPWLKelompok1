@extends('layouts.app')

@section('title', 'Tulis Pesan - JayMart')
@section('page-title', 'Tulis Pesan Baru')
@section('page-subtitle', 'Hubungi anggota tim Anda')

@section('content')
<div class="mt-40">
    <div class="max-w-full">
        <div class="bg-white rounded-xl card-shadow p-6">

            @if(count($contacts) === 0)
            <div class="text-center py-8">
                <i class="fas fa-user-slash text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">Tidak ada kontak yang tersedia untuk Anda hubungi.</p>
                <a href="{{ route('messages.inbox') }}" class="mt-3 inline-block text-blue-500 text-sm hover:underline">Kembali ke kotak masuk</a>
            </div>
            @else

            <div class="mb-5 p-3 bg-blue-50 rounded-lg text-sm text-blue-700">
                <i class="fas fa-info-circle mr-1"></i>
                Anda dapat mengirim pesan kepada:
                <strong>
                    @switch(auth()->user()->role)
                        @case('pemilik') Manajer cabang @break
                        @case('manajer') Pemilik & Supervisor cabang Anda @break
                        @case('supervisor') Manajer & Staff cabang Anda @break
                        @case('kasir') Supervisor cabang Anda @break
                        @case('gudang') Supervisor cabang Anda @break
                    @endswitch
                </strong>
            </div>

            <form method="POST" action="{{ route('messages.send') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kepada</label>
                    <select name="receiver_id" required class="w-full border rounded-lg px-3 py-2 text-sm">
                        <option value="">-- Pilih Penerima --</option>
                        @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}" {{ (old('receiver_id', $selectedReceiverId) == $contact->id) ? 'selected' : '' }}>
                            {{ $contact->name }} — {{ ucfirst($contact->role) }}
                            @if($contact->store) ({{ $contact->store->store_name }}) @endif
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="Contoh: Pengadaan produk baru..." class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                    <textarea name="body" required rows="6" placeholder="Tulis pesan Anda di sini..." class="w-full border rounded-lg px-3 py-2 text-sm resize-none">{{ old('body') }}</textarea>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        <i class="fas fa-paper-plane mr-1"></i> Kirim Pesan
                    </button>
                    <a href="{{ route('messages.inbox') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 text-sm">Batal</a>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
