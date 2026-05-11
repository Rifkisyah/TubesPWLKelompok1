<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Gudang tidak bisa akses transaksi
        if ($user->isWarehouse()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $query = Transaction::with(['user', 'store', 'items.product']);

        if (!$user->isOwner()) {
            $query->where('store_id', $user->store_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('pages.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $user = auth()->user();
        // Hanya kasir dan supervisor yang bisa buat transaksi
        if (!in_array($user->role, ['kasir', 'supervisor'])) {
            abort(403, 'Anda tidak memiliki akses untuk membuat transaksi.');
        }

        $products = Product::where('store_id', $user->store_id)->where('stock', '>', 0)->get();
        return view('pages.transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['kasir', 'supervisor'])) {
            abort(403);
        }

        $request->validate([
            'items'                => 'required|array|min:1',
            'items.*.product_id'   => 'required|exists:products,id',
            'items.*.quantity'     => 'required|integer|min:1',
            'payment_amount'       => 'required|integer|min:0',
        ]);

        $totalAmount = 0;
        $itemsData = [];

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            if ($product->store_id !== $user->store_id) {
                return back()->withErrors(['items' => "Produk {$product->product_name} bukan milik cabang Anda."]);
            }
            if ($product->stock < $item['quantity']) {
                return back()->withErrors(['items' => "Stok {$product->product_name} tidak mencukupi."]);
            }
            $subtotal = $product->price * $item['quantity'];
            $totalAmount += $subtotal;
            $itemsData[] = [
                'product_id' => $product->id,
                'quantity'   => $item['quantity'],
                'price'      => $product->price,
                'subtotal'   => $subtotal,
            ];
        }

        if ($request->payment_amount < $totalAmount) {
            return back()->withErrors(['payment_amount' => 'Pembayaran kurang dari total belanja.']);
        }

        $transaction = Transaction::create([
            'invoice_number' => 'INV-' . date('Ymd') . '-' . str_pad(Transaction::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT),
            'user_id'        => $user->id,
            'store_id'       => $user->store_id,
            'total_amount'   => $totalAmount,
            'payment_amount' => $request->payment_amount,
            'change_amount'  => $request->payment_amount - $totalAmount,
        ]);

        foreach ($itemsData as $itemData) {
            TransactionItem::create(array_merge($itemData, ['transaction_id' => $transaction->id]));
            Product::where('id', $itemData['product_id'])->decrement('stock', $itemData['quantity']);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show(Transaction $transaction)
    {
        $user = auth()->user();
        if ($user->isWarehouse()) {
            abort(403);
        }
        // Non-owner can only see their own store transactions
        if (!$user->isOwner() && $transaction->store_id !== $user->store_id) {
            abort(403);
        }
        $transaction->load(['user', 'store', 'items.product']);
        return view('pages.transactions.show', compact('transaction'));
    }
}
