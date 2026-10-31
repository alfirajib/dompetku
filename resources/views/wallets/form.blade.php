@extends('layouts.app')
@section('title', $wallet ? 'Edit Dompet' : 'Tambah Dompet')
@section('content')
<div class="card shadow-sm col-md-6"><div class="card-body">
    <h4 class="mb-3">{{ $wallet ? 'Edit' : 'Tambah' }} Dompet</h4>
    <form method="POST" action="{{ $wallet ? route('wallets.update', $wallet->id) : route('wallets.store') }}">
        @csrf
        @if($wallet) @method('PUT') @endif
        <div class="mb-3">
            <label for="name" class="form-label">Nama Dompet</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $wallet->name ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="initial_balance" class="form-label">Saldo Awal (Rp)</label>
            <input type="number" id="initial_balance" name="initial_balance" min="0" step="1" class="form-control" value="{{ old('initial_balance', isset($wallet) ? (int) $wallet->initial_balance : 0) }}" required>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('wallets.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div></div>
@endsection
