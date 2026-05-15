@extends('layouts.app')

@section('title', 'Pesan Terkirim - JayMart')
@section('page-title', 'Pesan Terkirim')
@section('page-subtitle', 'Riwayat pesan yang telah Anda kirim')

@section('content')
<div class="flex gap-4 mb-4">
    <a href="{{ route('messages.inbox') }}" class="px-4 py-2 text-sm rounded-lg bg-white text-gray-700 border hover:bg-gray-50">
        <i class="fas fa-inbox mr-1"></i> Masuk
    </a>
    <a href="{{ route('messages.sent') }}" class="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white">
        <i class="fas fa-paper-plane mr-1"></i> Terkirim
    </a>
    <a href="{{ route('messages.compose') }}" class="px-4 py-2 text-sm rounded-lg bg-green-600 text-white hover:bg-green-700 ml-auto">
        <i class="fas fa-pen mr-1"></i> Tulis Pesan
    </a>
</div>

<div class="bg-white rounded-xl card-shadow overflow-hidden">
    <div class="divide-y">
        @forelse($messages as $msg)
        <a href="{{ route('messages.show', $msg) }}" class="flex items-start gap-4 p-4 hover:bg-gray-50 transition">
            <div class="w-10 h-10 rounded-full bg-gray-500 flex items-center justify-center flex-shrink-0">
                <span class="text-white text-sm font-bold">{{ strtoupper(substr($msg->receiver->name, 0, 1)) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between mb-1">
                    <p class="text-sm font-semibold text-gray-800">
                        Ke: {{ $msg->receiver->name }}
                        <span class="text-xs font-normal text-gray-500 ml-1">({{ ucfirst($msg->receiver->role) }})</span>
                    </p>
                    <span class="text-xs text-gray-400">{{ $msg->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-sm font-medium text-gray-700 truncate">{{ $msg->subject }}</p>
                <p class="text-xs text-gray-500 truncate mt-0.5">{{ Str::limit($msg->body, 80) }}</p>
            </div>
        </a>
        @empty
        <div class="py-16 text-center">
            <i class="fas fa-paper-plane text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-400">Belum ada pesan terkirim.</p>
        </div>
        @endforelse
    </div>
    @if($messages->hasPages())
    <div class="p-4 border-t">{{ $messages->links() }}</div>
    @endif
</div>
@endsection

