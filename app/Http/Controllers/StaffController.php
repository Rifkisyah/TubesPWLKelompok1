<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * StaffController — digunakan oleh Supervisor untuk mengelola Kasir & Gudang di cabangnya
 */
class StaffController extends Controller
{
    public function __construct()
    {
        if (auth()->check() && !auth()->user()->isSupervisor()) {
            abort(403, 'Hanya Supervisor yang dapat mengakses halaman ini.');
        }
    }

    public function index()
    {
        $user = auth()->user();
        $staff = User::whereIn('role', ['kasir', 'gudang'])
            ->where('store_id', $user->store_id)
            ->with('store')
            ->paginate(15);

        return view('pages.staff.index', compact('staff'));
    }

    public function create()
    {
        $store = auth()->user()->store;
        return view('pages.staff.create', compact('store'));
    }

    public function store(Request $request)
    {
        $supervisor = auth()->user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:kasir,gudang',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'store_id' => $supervisor->store_id,
        ]);

        return redirect()->route('staff.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit(User $staff)
    {
        $supervisor = auth()->user();
        if (!in_array($staff->role, ['kasir', 'gudang']) || $staff->store_id !== $supervisor->store_id) {
            abort(403);
        }
        $store = $supervisor->store;
        return view('pages.staff.edit', compact('staff', 'store'));
    }

    public function update(Request $request, User $staff)
    {
        $supervisor = auth()->user();
        if (!in_array($staff->role, ['kasir', 'gudang']) || $staff->store_id !== $supervisor->store_id) {
            abort(403);
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'role'  => 'required|in:kasir,gudang',
        ]);

        $data = $request->only('name', 'email', 'role');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);
        return redirect()->route('staff.index')->with('success', 'Pegawai berhasil diperbarui.');
    }

    public function destroy(User $staff)
    {
        $supervisor = auth()->user();
        if (!in_array($staff->role, ['kasir', 'gudang']) || $staff->store_id !== $supervisor->store_id) {
            abort(403);
        }
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
