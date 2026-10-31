@extends('layouts.app')
@section('title', 'Dompet')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Dompet / Rekening</h4>
    <a href="{{ route('wallets.create') }}" class="btn btn-primary">+ Tambah Dompet</a>
</div>
<div class="card shadow-sm"><div class="table-responsive">
    <table class="table mb-0 align-middle">
        <thead><tr><th>Nama</th><th class="text-end">Saldo Awal</th><th class="text-end">Saldo Saat Ini</th><th class="text-end">Aksi</th></tr></thead>
        <tbody>
        @forelse($wallets as $w)
            <tr>
                <td>{{ $w->name }}</td>
                <td class="text-end">Rp {{ number_format($w->initial_balance, 0, ',', '.') }}</td>
                <td class="text-end fw-bold">Rp {{ number_format($w->balance, 0, ',', '.') }}</td>
                <td class="text-end">
                    <a href="{{ route('wallets.edit', $w->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('wallets.destroy', $w->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus dompet ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted">Belum ada dompet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
@endsection
