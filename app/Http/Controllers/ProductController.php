<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Kasir tidak boleh akses produk
        if ($user->isCashier()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $query = Product::with(['category', 'store']);

        if (!$user->isOwner()) {
            $query->where('store_id', $user->store_id);
        }

        $products = $query->paginate(15);
        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        $user = auth()->user();
        // Hanya supervisor dan gudang yang bisa tambah produk
        if (!in_array($user->role, ['supervisor', 'gudang'])) {
            abort(403, 'Anda tidak memiliki akses untuk menambah produk.');
        }

        $categories = ProductCategory::all();
        $stores = $user->isOwner() ? Store::all() : Store::where('id', $user->store_id)->get();
        return view('pages.products.create', compact('categories', 'stores'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['supervisor', 'gudang'])) {
            abort(403);
        }

        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id'  => 'required|exists:product_categories,id',
            'store_id'     => 'required|exists:stores,id',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
        ]);

        // Force store_id to user's store for non-owner
        $storeId = $user->isOwner() ? $request->store_id : $user->store_id;

        Product::create([
            'product_name' => $request->product_name,
            'category_id'  => $request->category_id,
            'price'        => $request->price,
            'stock'        => $request->stock,
            'store_id'     => $storeId,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['supervisor', 'gudang'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit produk.');
        }
        // Can only edit products in own store
        if (!$user->isOwner() && $product->store_id !== $user->store_id) {
            abort(403);
        }

        $categories = ProductCategory::all();
        $stores = Store::where('id', $user->store_id)->get();
        return view('pages.products.edit', compact('product', 'categories', 'stores'));
    }

    public function update(Request $request, Product $product)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['supervisor', 'gudang'])) {
            abort(403);
        }
        if (!$user->isOwner() && $product->store_id !== $user->store_id) {
            abort(403);
        }

        $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id'  => 'required|exists:product_categories,id',
            'store_id'     => 'required|exists:stores,id',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
        ]);

        $product->update($request->only('product_name', 'category_id', 'store_id', 'price', 'stock'));
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['supervisor', 'gudang'])) {
            abort(403);
        }
        if (!$user->isOwner() && $product->store_id !== $user->store_id) {
            abort(403);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
