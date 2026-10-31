@extends('layouts.app')
@section('title', $category ? 'Edit Kategori' : 'Tambah Kategori')
@section('content')
<div class="card shadow-sm col-md-6"><div class="card-body">
    <h4 class="mb-3">{{ $category ? 'Edit' : 'Tambah' }} Kategori</h4>
    <form method="POST" action="{{ $category ? route('categories.update', $category->id) : route('categories.store') }}">
        @csrf
        @if($category) @method('PUT') @endif
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Jenis</label>
            <select id="type" name="type" class="form-select" required>
                <option value="income" @selected(old('type', $category->type ?? '') === 'income')>Pemasukan</option>
                <option value="expense" @selected(old('type', $category->type ?? '') === 'expense')>Pengeluaran</option>
            </select>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div></div>
@endsection
