@extends('layouts.app')
@section('title', 'Kelola Pengguna')
@section('content')
<h4 class="mb-3">Kelola Pengguna <span class="badge bg-secondary">Admin</span></h4>
<div class="card shadow-sm"><div class="table-responsive">
    <table class="table mb-0 align-middle">
        <thead><tr><th>#</th><th>Nama</th><th>Email</th><th>Role</th><th>Dompet</th><th>Transaksi</th><th>Terdaftar</th><th class="text-end">Aksi</th></tr></thead>
        <tbody>
        @foreach($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td><span class="badge {{ $u->role === 'admin' ? 'bg-primary' : 'bg-secondary' }}">{{ $u->role }}</span></td>
                <td>{{ $u->wallets_count }}</td>
                <td>{{ $u->transactions_count }}</td>
                <td>{{ $u->created_at->format('d/m/Y') }}</td>
                <td class="text-end">
                    @if($u->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pengguna beserta seluruh datanya?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div></div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
