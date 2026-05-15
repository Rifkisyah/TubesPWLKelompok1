@extends('layouts.app')

@section('title', '{{ $message->subject }} - JayMart')
@section('page-title', 'Detail Pesan')

@section('content')
<div class="mt-40">
    <div class="max-w-full">
        <div class="mb-4 flex gap-3">
            <a href="{{ route('messages.inbox') }}" class="text-sm text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Kotak Masuk
            </a>
        </div>

        <div class="bg-white rounded-xl card-shadow overflow-hidden mb-4">
            {{-- Header --}}
            <div class="p-6 border-b bg-gray-50">
                <h2 class="text-xl font-bold text-gray-800 mb-3">{{ $message->subject }}</h2>
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center">
                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($message->sender->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $message->sender->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($message->sender->role) }}
                                @if($message->sender->store) — {{ $message->sender->store->store_name }} @endif
                            </p>
                        </div>
                        <i class="fas fa-arrow-right text-gray-400 mx-1"></i>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $message->receiver->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($message->receiver->role) }}</p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400">{{ $message->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-6">
                <div class="prose prose-sm max-w-none text-gray-700 whitespace-pre-line leading-relaxed">{{ $message->body }}</div>
            </div>

            {{-- Actions --}}
            <div class="p-6 border-t bg-gray-50 flex gap-3">
                @if(in_array(auth()->id(), [$message->receiver_id, $message->sender_id]))
                <button onclick="document.getElementById('replyForm').classList.toggle('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                    <i class="fas fa-reply mr-1"></i> Balas
                </button>
                @endif
                <a href="{{ route('messages.compose', ['to' => $message->sender_id === auth()->id() ? $message->receiver_id : $message->sender_id]) }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-300">
                    <i class="fas fa-pen mr-1"></i> Pesan Baru
                </a>
                <form action="{{ route('messages.destroy', $message) }}" method="POST" class="ml-auto" onsubmit="return confirm('Hapus pesan ini?')">
                    @csrf @method('DELETE')
                    <button class="text-red-500 hover:text-red-700 px-3 py-2 text-sm border border-red-200 rounded-lg hover:bg-red-50">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- Reply Form --}}
        <div id="replyForm" class="hidden bg-white rounded-xl card-shadow p-6">
            <h3 class="text-base font-semibold text-gray-800 mb-4"><i class="fas fa-reply mr-2 text-blue-500"></i>Balas Pesan</h3>
            <form method="POST" action="{{ route('messages.reply', $message) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pesan Balasan</label>
                    <textarea name="body" required rows="5" placeholder="Tulis balasan Anda..." class="w-full border rounded-lg px-3 py-2 text-sm resize-none">{{ old('body') }}</textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 text-sm">
                        <i class="fas fa-paper-plane mr-1"></i> Kirim Balasan
                    </button>
                    <button type="button" onclick="document.getElementById('replyForm').classList.add('hidden')" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-300">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
