@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Laporan Keuangan</h2>
        <p class="text-muted">Analisis mendalam mengenai arus kas tahun ini.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card p-4 shadow-sm border-0">
            <small class="text-muted fw-bold">TOTAL TABUNGAN</small>
            <h3 class="fw-bold mt-2 text-success">Rp {{ number_format($netSavings, 0, ',', '.') }}</h3>
            <div class="progress mt-2" style="height: 5px;"><div class="progress-bar bg-success" style="width: 100%"></div></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 shadow-sm border-0">
            <small class="text-muted fw-bold">RASIO PENGELUARAN</small>
            <h3 class="fw-bold mt-2 text-danger">
                {{ $totalIncome > 0 ? round(($totalExpense / $totalIncome) * 100) : 0 }}%
            </h3>
            <p class="small text-muted mb-0">dari total pemasukan</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 shadow-sm border-0">
            <small class="text-muted fw-bold">KATEGORI TERBOROS</small>
            <h3 class="fw-bold mt-2 text-dark">{{ $categories->sortByDesc('transactions_sum_jumlah')->first()->nama ?? '-' }}</h3>
            <p class="small text-muted mb-0">Perlu perhatian lebih</p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card p-4 shadow-sm border-0 h-100">
            <h5 class="fw-bold mb-4">Tren Pemasukan vs Pengeluaran</h5>
            <canvas id="trendChart" height="280"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4 shadow-sm border-0 h-100">
            <h5 class="fw-bold mb-4">Alokasi Pengeluaran</h5>
            <canvas id="categoryDonut" height="250"></canvas>
            <div class="mt-4">
                @foreach($categories->sortByDesc('total_spent')->take(4) as $cat)
<div class="d-flex justify-content-between small mb-2">
    <span>
        <i class="bi bi-circle-fill me-2" style="color: {{ ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'][$loop->index] ?? '#6366f1' }}"></i> 
        {{ $cat->nama }}
    </span>
    {{-- Pakai total_spent di sini --}}
    <span class="fw-bold">Rp {{ number_format($cat->total_spent ?? 0, 0, ',', '.') }}</span>
</div>
@endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Logic Trend Chart (Line Chart)
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
    labels: @json($months),
    datasets: [
        {
            label: 'Pemasukan',
            data: @json($incomeTrend), // Data dinamis dari database
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            fill: true,
            tension: 0.4
        },
        {
            label: 'Pengeluaran',
            data: @json($expenseTrend), // Data dinamis dari database
            borderColor: '#ef4444',
            backgroundColor: 'rgba(239, 68, 68, 0.1)',
            fill: true,
            tension: 0.4
        }
    ]
},
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } },
            scales: { y: { beginAtZero: true, grid: { display: false } } }
        }
    });

    // 2. Logic Donut Chart
    const donutCtx = document.getElementById('categoryDonut').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
      data: {
    labels: @json($categories->pluck('nama')),
    datasets: [{
        // Pastikan total_spent di sini sesuai dengan alias di Controller
        data: @json($categories->pluck('total_spent')), 
        backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#6366f1'],
        borderWidth: 0
    }]
},
        options: {
            cutout: '70%',
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush