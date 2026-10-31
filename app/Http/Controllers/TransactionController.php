<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'type' => ['nullable', 'in:income,expense'],
            'month' => ['nullable', 'date_format:Y-m'],
        ]);

        $query = $request->user()->transactions()->with(['category', 'wallet']);

        if ($request->filled('type')) {
            $query->where('type', $request->query('type'));
        }

        if ($request->filled('month')) {
            $month = Carbon::parse($request->query('month').'-01');
            $query->whereBetween('transaction_date', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()]);
        }

        $transactions = $query->latest('transaction_date')->latest('id')->paginate(10)->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        return view('transactions.form', $this->formData($request) + ['transaction' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->prepare($request);

        $request->user()->transactions()->create($data);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dicatat.');
    }

    public function edit(Request $request, string $id)
    {
        $transaction = $request->user()->transactions()->findOrFail($id);

        return view('transactions.form', $this->formData($request) + compact('transaction'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $transaction = $request->user()->transactions()->findOrFail($id);

        $transaction->update($this->prepare($request));

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $request->user()->transactions()->findOrFail($id)->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    private function formData(Request $request): array
    {
        return [
            'wallets' => $request->user()->wallets()->orderBy('name')->get(),
            'categories' => $request->user()->categories()->orderBy('name')->get(),
        ];
    }

    /** Validasi server-side + sanitasi + turunkan 'type' dari kategori */
    private function prepare(Request $request): array
    {
        $uid = $request->user()->id;

        $data = $request->validate([
            // exists + where user_id => tidak bisa memakai wallet/kategori milik user lain
            'wallet_id' => ['required', 'integer', Rule::exists('wallets', 'id')->where('user_id', $uid)],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->where('user_id', $uid)],
            'amount' => ['required', 'numeric', 'min:1', 'max:999999999999'],
            'description' => ['nullable', 'string', 'max:255'],
            'transaction_date' => ['required', 'date'],
        ]);

        $category = $request->user()->categories()->findOrFail($data['category_id']);
        $data['type'] = $category->type;
        $data['description'] = isset($data['description']) ? strip_tags($data['description']) : null;

        return $data;
    }
}
