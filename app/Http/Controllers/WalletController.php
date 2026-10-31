<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $wallets = $request->user()->wallets()->orderBy('name')->get();

        return view('wallets.index', compact('wallets'));
    }

    public function create()
    {
        return view('wallets.form', ['wallet' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['name'] = strip_tags($data['name']);

        $request->user()->wallets()->create($data);

        return redirect()->route('wallets.index')->with('success', 'Dompet berhasil ditambahkan.');
    }

    public function edit(Request $request, string $id)
    {
        $wallet = $request->user()->wallets()->findOrFail($id);

        return view('wallets.form', compact('wallet'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $wallet = $request->user()->wallets()->findOrFail($id);

        $data = $this->validated($request);
        $data['name'] = strip_tags($data['name']);

        $wallet->update($data);

        return redirect()->route('wallets.index')->with('success', 'Dompet berhasil diperbarui.');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $wallet = $request->user()->wallets()->findOrFail($id);

        if ($wallet->transactions()->exists()) {
            return back()->with('error', 'Dompet tidak dapat dihapus karena masih memiliki transaksi.');
        }

        $wallet->delete();

        return redirect()->route('wallets.index')->with('success', 'Dompet berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'initial_balance' => ['required', 'numeric', 'min:0', 'max:999999999999'],
        ]);
    }
}
