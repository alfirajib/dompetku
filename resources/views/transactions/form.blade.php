@extends('layouts.app')
@section('title', $transaction ? 'Edit Transaksi' : 'Catat Transaksi')
@section('content')
<div class="card shadow-sm col-md-7"><div class="card-body">
    <h4 class="mb-3">{{ $transaction ? 'Edit' : 'Catat' }} Transaksi</h4>

    @if($wallets->isEmpty() || $categories->isEmpty())
        <div class="alert alert-warning">
            Buat minimal satu <a href="{{ route('wallets.create') }}">dompet</a> dan satu
            <a href="{{ route('categories.create') }}">kategori</a> terlebih dahulu.
        </div>
    @endif

    <form method="POST" action="{{ $transaction ? route('transactions.update', $transaction->id) : route('transactions.store') }}">
        @csrf
        @if($transaction) @method('PUT') @endif

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select id="category_id" name="category_id" class="form-select" required>
                <option value="">-- pilih --</option>
                @foreach(['income' => 'Pemasukan', 'expense' => 'Pengeluaran'] as $type => $label)
                    <optgroup label="{{ $label }}">
                        @foreach($categories->where('type', $type) as $c)
                            <option value="{{ $c->id }}" @selected(old('category_id', $transaction->category_id ?? null) == $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="wallet_id" class="form-label">Dompet</label>
            <select id="wallet_id" name="wallet_id" class="form-select" required>
                <option value="">-- pilih --</option>
                @foreach($wallets as $w)
                    <option value="{{ $w->id }}" @selected(old('wallet_id', $transaction->wallet_id ?? null) == $w->id)>{{ $w->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Nominal (Rp)</label>
            <input type="number" id="amount" name="amount" min="1" step="1" class="form-control"
                   value="{{ old('amount', isset($transaction) ? (int) $transaction->amount : '') }}" required>
        </div>

        <div class="mb-3">
            <label for="transaction_date" class="form-label">Tanggal</label>
            <input type="date" id="transaction_date" name="transaction_date" class="form-control"
                   value="{{ old('transaction_date', isset($transaction) ? $transaction->transaction_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Keterangan (opsional)</label>
            <input type="text" id="description" name="description" maxlength="255" class="form-control"
                   value="{{ old('description', $transaction->description ?? '') }}">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div></div>
@endsection
