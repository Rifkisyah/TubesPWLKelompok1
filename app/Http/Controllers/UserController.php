<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user->isOwner()) {
            abort(403, 'Hanya Pemilik yang dapat mengakses manajemen user.');
        }

        $users = User::with('store')->paginate(15);
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        if (!auth()->user()->isOwner()) {
            abort(403);
        }
        $stores = Store::all();
        return view('pages.users.create', compact('stores'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isOwner()) {
            abort(403);
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:pemilik,manajer,supervisor,kasir,gudang',
            'store_id' => 'nullable|exists:stores,id',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'store_id' => $request->store_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if (!auth()->user()->isOwner()) {
            abort(403);
        }
        $stores = Store::all();
        return view('pages.users.edit', compact('user', 'stores'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->isOwner()) {
            abort(403);
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:pemilik,manajer,supervisor,kasir,gudang',
            'store_id' => 'nullable|exists:stores,id',
        ]);

        $data = $request->only('name', 'email', 'role', 'store_id');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->isOwner()) {
            abort(403);
        }
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun sendiri.']);
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
