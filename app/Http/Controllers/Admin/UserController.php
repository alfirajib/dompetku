<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount(['wallets', 'transactions'])->orderBy('id')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->id === $request->user()->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete(); // data wallet/kategori/transaksi ikut terhapus (cascade)

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
