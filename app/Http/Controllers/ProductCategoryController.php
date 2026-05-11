<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Kasir dan Gudang tidak bisa akses kategori
        if (in_array($user->role, ['kasir', 'gudang'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $categories = ProductCategory::withCount('products')->paginate(15);
        return view('pages.categories.index', compact('categories'));
    }

    public function create()
    {
        // Hanya supervisor yang bisa tambah kategori
        if (!auth()->user()->isSupervisor()) {
            abort(403, 'Hanya Supervisor yang dapat mengelola kategori.');
        }
        return view('pages.categories.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isSupervisor()) {
            abort(403);
        }
        $request->validate(['category_name' => 'required|string|max:255']);
        ProductCategory::create($request->only('category_name'));
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(ProductCategory $category)
    {
        if (!auth()->user()->isSupervisor()) {
            abort(403, 'Hanya Supervisor yang dapat mengelola kategori.');
        }
        return view('pages.categories.edit', compact('category'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        if (!auth()->user()->isSupervisor()) {
            abort(403);
        }
        $request->validate(['category_name' => 'required|string|max:255']);
        $category->update($request->only('category_name'));
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(ProductCategory $category)
    {
        if (!auth()->user()->isSupervisor()) {
            abort(403);
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
