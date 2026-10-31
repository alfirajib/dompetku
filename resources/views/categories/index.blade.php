@extends('layouts.app')
@section('title', 'Kategori')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Kategori</h4>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
</div>
<div class="card shadow-sm"><div class="table-responsive">
    <table class="table mb-0 align-middle">
        <thead><tr><th>Nama</th><th>Jenis</th><th>Dipakai</th><th class="text-end">Aksi</th></tr></thead>
        <tbody>
        @forelse($categories as $c)
            <tr>
                <td>{{ $c->name }}</td>
                <td><span class="badge {{ $c->type === 'income' ? 'bg-success' : 'bg-danger' }}">{{ $c->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}</span></td>
                <td>{{ $c->transactions_count }} transaksi</td>
                <td class="text-end">
                    <a href="{{ route('categories.edit', $c->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('categories.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted">Belum ada kategori.</td></tr>
        @endforelse
        </tbody>
    </table>
</div></div>
@endsection
