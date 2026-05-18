@extends('layouts.app')

@section('title', 'Transaksi Baru - JayMart')
@section('page-title', 'Transaksi Baru')
@section('page-subtitle', 'Buat transaksi penjualan')

@section('content')
<div class="bg-white rounded-xl card-shadow p-6">
    <form method="POST" action="{{ route('transactions.store') }}" id="transactionForm">
        @csrf
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Item Belanja</h3>
            <div id="items-container">
                <div class="item-row flex gap-4 mb-3 items-end">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                        <select name="items[0][product_id]" required class="w-full border rounded-lg px-3 py-2 text-sm product-select">
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                                    {{ $product->product_name }} (Stok: {{ $product->stock }}) - Rp {{ number_format($product->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-32">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                        <input type="number" name="items[0][quantity]" min="1" value="1" required class="w-full border rounded-lg px-3 py-2 text-sm qty-input">
                    </div>
                    <div class="w-40">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subtotal</label>
                        <p class="subtotal-display text-sm font-semibold text-gray-800 py-2">Rp 0</p>
                    </div>
                </div>
            </div>
            <button type="button" id="addItem" class="mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                <i class="fas fa-plus mr-1"></i> Tambah Item
            </button>
        </div>

        <div class="border-t pt-4">
            <div class="flex justify-between items-center mb-4">
                <span class="text-lg font-semibold">Total:</span>
                <span id="grandTotal" class="text-2xl font-bold text-blue-600">Rp 0</span>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bayar</label>
                <input type="number" name="payment_amount" id="paymentAmount" required min="0" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div class="flex justify-between items-center mb-6">
                <span class="text-sm text-gray-600">Kembalian:</span>
                <span id="changeAmount" class="text-lg font-semibold text-green-600">Rp 0</span>
            </div>
            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                <i class="fas fa-check mr-2"></i>Simpan Transaksi
            </button>
        </div>
    </form>
</div>
<div class="mb-4 flex gap-3 m-5">
    <a href="{{ route('transactions.index') }}" class="text-sm text-gray-500 hover:text-red-700">
        <i class="fas fa-arrow-left mr-1"></i> Kembali
    </a>
</div>
@endsection

@push('scripts')
<script>
let itemIndex = 1;

document.getElementById('addItem').addEventListener('click', function() {
    const container = document.getElementById('items-container');
    const row = document.createElement('div');
    row.className = 'item-row flex gap-4 mb-3 items-end';
    row.innerHTML = `
        <div class="flex-1">
            <select name="items[${itemIndex}][product_id]" required class="w-full border rounded-lg px-3 py-2 text-sm product-select">
                <option value="">Pilih Produk</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                        {{ $product->product_name }} (Stok: {{ $product->stock }}) - Rp {{ number_format($product->price, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="w-32">
            <input type="number" name="items[${itemIndex}][quantity]" min="1" value="1" required class="w-full border rounded-lg px-3 py-2 text-sm qty-input">
        </div>
        <div class="w-40">
            <p class="subtotal-display text-sm font-semibold text-gray-800 py-2">Rp 0</p>
        </div>
        <button type="button" class="remove-item text-red-500 hover:text-red-700 pb-2"><i class="fas fa-trash"></i></button>
    `;
    container.appendChild(row);
    itemIndex++;
    bindEvents();
});

function bindEvents() {
    document.querySelectorAll('.product-select, .qty-input').forEach(el => {
        el.removeEventListener('change', calculate);
        el.addEventListener('change', calculate);
        el.removeEventListener('input', calculate);
        el.addEventListener('input', calculate);
    });
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.onclick = function() { this.closest('.item-row').remove(); calculate(); };
    });
}

function calculate() {
    let total = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const select = row.querySelector('.product-select');
        const qty = row.querySelector('.qty-input');
        const display = row.querySelector('.subtotal-display');
        if (select.value && qty.value) {
            const price = parseInt(select.selectedOptions[0].dataset.price);
            const subtotal = price * parseInt(qty.value);
            display.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            total += subtotal;
        }
    });
    document.getElementById('grandTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
    const payment = parseInt(document.getElementById('paymentAmount').value) || 0;
    const change = payment - total;
    document.getElementById('changeAmount').textContent = 'Rp ' + (change >= 0 ? change : 0).toLocaleString('id-ID');
}

document.getElementById('paymentAmount').addEventListener('input', calculate);
bindEvents();
</script>
@endpush
