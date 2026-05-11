<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Kasir tidak bisa akses stok
        if ($user->isCashier()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $query = Product::with(['category', 'store']);

        if (!$user->isOwner()) {
            $query->where('store_id', $user->store_id);
        }

        $products = $query->orderBy('stock', 'asc')->paginate(15);
        return view('pages.stock.index', compact('products'));
    }

    public function movements(Request $request)
    {
        $user = auth()->user();
        if ($user->isCashier()) {
            abort(403);
        }

        $query = StockMovement::with(['product', 'store', 'user']);

        if (!$user->isOwner()) {
            $query->where('store_id', $user->store_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $movements = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('pages.stock.movements', compact('movements'));
    }

    public function create()
    {
        $user = auth()->user();
        // Hanya supervisor dan gudang yang bisa tambah pergerakan stok
        if (!in_array($user->role, ['supervisor', 'gudang'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengelola stok.');
        }

        $products = Product::where('store_id', $user->store_id)->get();
        $stores = Store::where('id', $user->store_id)->get();
        return view('pages.stock.create', compact('products', 'stores'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['supervisor', 'gudang'])) {
            abort(403);
        }

        $request->validate([
            'product_id'  => 'required|exists:products,id',
            'store_id'    => 'required|exists:stores,id',
            'type'        => 'required|in:masuk,keluar',
            'quantity'    => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Validate the product belongs to user's store
        if ($product->store_id !== $user->store_id) {
            abort(403, 'Produk bukan milik cabang Anda.');
        }

        if ($request->type === 'keluar' && $product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi.']);
        }

        StockMovement::create([
            'product_id'  => $request->product_id,
            'store_id'    => $user->store_id,
            'user_id'     => $user->id,
            'type'        => $request->type,
            'quantity'    => $request->quantity,
            'description' => $request->description,
        ]);

        if ($request->type === 'masuk') {
            $product->increment('stock', $request->quantity);
        } else {
            $product->decrement('stock', $request->quantity);
        }

        return redirect()->route('stock.index')->with('success', 'Pergerakan stok berhasil dicatat.');
    }
}
