@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<h4 class="mb-3">Ringkasan Keuangan — {{ now()->translatedFormat('F Y') }}</h4>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-success shadow-sm"><div class="card-body">
            <div class="text-muted">Pemasukan bulan ini</div>
            <div class="fs-4 fw-bold text-success">Rp {{ number_format($monthIncome, 0, ',', '.') }}</div>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card border-danger shadow-sm"><div class="card-body">
            <div class="text-muted">Pengeluaran bulan ini</div>
            <div class="fs-4 fw-bold text-danger">Rp {{ number_format($monthExpense, 0, ',', '.') }}</div>
        </div></div>
    </div>
    <div class="col-md-4">
        <div class="card border-primary shadow-sm"><div class="card-body">
            <div class="text-muted">Total saldo semua dompet</div>
            <div class="fs-4 fw-bold text-primary">Rp {{ number_format($totalBalance, 0, ',', '.') }}</div>
        </div></div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="card shadow-sm"><div class="card-body">
            <h6>Tren 6 Bulan Terakhir</h6>
            <canvas id="trendChart" height="130"></canvas>
        </div></div>
    </div>
    <div class="col-lg-5">
        <div class="card shadow-sm"><div class="card-body">
            <h6>Pengeluaran per Kategori (bulan ini)</h6>
            @if($byCategory->isEmpty())
                <p class="text-muted mb-0">Belum ada pengeluaran bulan ini.</p>
            @else
                <canvas id="categoryChart" height="200"></canvas>
            @endif
        </div></div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <h6 class="mb-0">5 Transaksi Terakhir</h6>
            <a href="{{ route('transactions.create') }}" class="btn btn-sm btn-primary">+ Catat Transaksi</a>
        </div>
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead><tr><th>Tanggal</th><th>Kategori</th><th>Dompet</th><th>Keterangan</th><th class="text-end">Nominal</th></tr></thead>
                <tbody>
                @forelse($recent as $t)
                    <tr>
                        <td>{{ $t->transaction_date->format('d/m/Y') }}</td>
                        <td>{{ $t->category->name }}</td>
                        <td>{{ $t->wallet->name }}</td>
                        <td>{{ $t->description }}</td>
                        <td class="text-end {{ $t->type === 'income' ? 'text-success' : 'text-danger' }}">
                            {{ $t->type === 'income' ? '+' : '-' }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">Belum ada transaksi.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
    const trend = @json($trend);
    new Chart(document.getElementById('trendChart'), {
        type: 'bar',
        data: {
            labels: trend.map(t => t.label),
            datasets: [
                { label: 'Pemasukan', data: trend.map(t => t.income), backgroundColor: '#198754' },
                { label: 'Pengeluaran', data: trend.map(t => t.expense), backgroundColor: '#dc3545' }
            ]
        }
    });

    @if($byCategory->isNotEmpty())
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: @json($byCategory->keys()),
            datasets: [{ data: @json($byCategory->values()) }]
        }
    });
    @endif
</script>
@endpush
