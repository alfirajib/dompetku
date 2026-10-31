@extends('layouts.app')
@section('title', 'Transaksi')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Transaksi</h4>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary">+ Catat Transaksi</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="type" class="form-select">
            <option value="">Semua jenis</option>
            <option value="income" @selected(request('type') === 'income')>Pemasukan</option>
            <option value="expense" @selected(request('type') === 'expense')>Pengeluaran</option>
        </select>
    </div>
    <div class="col-md-3">
        <input type="month" name="month" class="form-control" value="{{ request('month') }}">
    </div>
    <div class="col-md-3">
        <button class="btn btn-outline-primary">Filter</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>

<div class="card shadow-sm"><div class="table-responsive">
    <table class="table mb-0 align-middle">
        <thead><tr><th>Tanggal</th><th>Kategori</th><th>Dompet</th><th>Keterangan</th><th class="text-end">Nominal</th><th class="text-end">Aksi</th></tr></thead>
        <tbody>
        @forelse($transactions as $t)
            <tr>
                <td>{{ $t->transaction_date->format('d/m/Y') }}</td>
                <td>{{ $t->category->name }}</td>
                <td>{{ $t->wallet->name }}</td>
                <td>{{ $t->description }}</td>
                <td class="text-end {{ $t->type === 'income' ? 'text-success' : 'text-danger' }}">
                    {{ $t->type === 'income' ? '+' : '-' }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                </td>
                <td class="text-end">
                    <a href="{{ route('transactions.edit', $t->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('transactions.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted">Tidak ada transaksi.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
<div class="mt-3">{{ $transactions->links() }}</div>
@endsection
