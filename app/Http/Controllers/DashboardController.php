<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();

        // Ringkasan bulan ini
        $monthIncome = $user->transactions()->where('type', 'income')
            ->whereBetween('transaction_date', [$start, $end])->sum('amount');
        $monthExpense = $user->transactions()->where('type', 'expense')
            ->whereBetween('transaction_date', [$start, $end])->sum('amount');

        // Total saldo semua dompet
        $totalBalance = $user->wallets()->sum('initial_balance')
            + $user->transactions()->where('type', 'income')->sum('amount')
            - $user->transactions()->where('type', 'expense')->sum('amount');

        // Pengeluaran per kategori bulan ini
        $byCategory = $user->transactions()->with('category:id,name')
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$start, $end])
            ->get()
            ->groupBy(fn ($t) => $t->category->name)
            ->map(fn ($group) => (float) $group->sum('amount'))
            ->sortDesc();

        // Tren 6 bulan terakhir
        $trend = collect(range(5, 0))->map(function ($i) use ($user) {
            $m = now()->startOfMonth()->subMonths($i);
            $range = [$m->copy()->startOfMonth(), $m->copy()->endOfMonth()];

            return [
                'label' => $m->translatedFormat('M Y'),
                'income' => (float) $user->transactions()->where('type', 'income')->whereBetween('transaction_date', $range)->sum('amount'),
                'expense' => (float) $user->transactions()->where('type', 'expense')->whereBetween('transaction_date', $range)->sum('amount'),
            ];
        });

        $recent = $user->transactions()->with(['category', 'wallet'])
            ->latest('transaction_date')->latest('id')->take(5)->get();

        return view('dashboard', compact(
            'monthIncome', 'monthExpense', 'totalBalance', 'byCategory', 'trend', 'recent'
        ));
    }
}
