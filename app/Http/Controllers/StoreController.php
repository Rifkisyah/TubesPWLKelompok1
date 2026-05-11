<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::withCount(['users', 'products', 'transactions'])->paginate(15);
        return view('pages.stores.index', compact('stores'));
    }

    public function create()
    {
        return view('pages.stores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
        ]);

        Store::create($request->only('store_name', 'city', 'address', 'phone'));
        return redirect()->route('stores.index')->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function edit(Store $store)
    {
        return view('pages.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $store->update($request->only('store_name', 'city', 'address', 'phone'));
        return redirect()->route('stores.index')->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('stores.index')->with('success', 'Cabang berhasil dihapus.');
    }
}
