<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * SupervisorController — digunakan oleh Manajer untuk mengelola Supervisor di cabangnya
 */
class SupervisorController extends Controller
{
    public function __construct()
    {
        // Hanya manajer yang boleh akses
        if (auth()->check() && !auth()->user()->isManager()) {
            abort(403, 'Hanya Manajer yang dapat mengakses halaman ini.');
        }
    }

    public function index()
    {
        $user = auth()->user();
        $supervisors = User::where('role', 'supervisor')
            ->where('store_id', $user->store_id)
            ->with('store')
            ->paginate(15);

        return view('pages.supervisors.index', compact('supervisors'));
    }

    public function create()
    {
        $store = auth()->user()->store;
        return view('pages.supervisors.create', compact('store'));
    }

    public function store(Request $request)
    {
        $manager = auth()->user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'supervisor',
            'store_id' => $manager->store_id,
        ]);

        return redirect()->route('supervisors.index')->with('success', 'Supervisor berhasil ditambahkan.');
    }

    public function edit(User $supervisor)
    {
        $manager = auth()->user();
        if ($supervisor->role !== 'supervisor' || $supervisor->store_id !== $manager->store_id) {
            abort(403);
        }
        $store = $manager->store;
        return view('pages.supervisors.edit', compact('supervisor', 'store'));
    }

    public function update(Request $request, User $supervisor)
    {
        $manager = auth()->user();
        if ($supervisor->role !== 'supervisor' || $supervisor->store_id !== $manager->store_id) {
            abort(403);
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $supervisor->id,
        ]);

        $data = $request->only('name', 'email');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $supervisor->update($data);
        return redirect()->route('supervisors.index')->with('success', 'Supervisor berhasil diperbarui.');
    }

    public function destroy(User $supervisor)
    {
        $manager = auth()->user();
        if ($supervisor->role !== 'supervisor' || $supervisor->store_id !== $manager->store_id) {
            abort(403);
        }
        $supervisor->delete();
        return redirect()->route('supervisors.index')->with('success', 'Supervisor berhasil dihapus.');
    }
}
