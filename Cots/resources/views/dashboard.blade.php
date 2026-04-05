@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold">Ringkasan Dasbor</h2>
    <p class="text-muted">Selamat datang kembali, anggaran saat ini <span class="text-success fw-bold">terkendali</span>.</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card p-4">
            <small class="text-uppercase text-muted fw-bold">Total Saldo</small>
            <h3 class="fw-bold mt-2">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
            <p class="text-success small mb-0 fw-bold">+2.4% <span class="text-muted fw-normal text-lowercase">dari bulan lalu</span></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4">
            <small class="text-uppercase text-muted fw-bold">Total Pemasukan</small>
            <h3 class="fw-bold mt-2">Rp {{ number_format($pemasukan, 0, ',', '.') }}</h3>
            <p class="text-primary small mb-0 fw-bold">Konsisten <span class="text-muted fw-normal text-lowercase">Beasiswa & Kerja</span></p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4">
            <small class="text-uppercase text-muted fw-bold">Total Pengeluaran</small>
            <h3 class="fw-bold mt-2">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</h3>
            <p class="text-danger small mb-0 fw-bold">-12% <span class="text-muted fw-normal text-lowercase">Laju pengeluaran</span></p>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Aliran Keluar Bulanan</h5>
                <select class="form-select form-select-sm w-auto border-0 bg-light">
                    <option>Semester Ini</option>
                </select>
            </div>
            <canvas id="outflowChart" height="250"></canvas>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-4 mb-4">
        <h5 class="fw-bold mb-4">Target Anggaran</h5>
        @forelse($budgetCategories as $cat)
        <div class="mb-4">
            <div class="d-flex justify-content-between mb-1 small">
                <span>{{ $cat->nama }}</span>
                <span class="fw-bold">{{ $cat->persentase }}%</span>
            </div>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar {{ $cat->persentase > 90 ? 'bg-danger' : 'bg-success' }}" 
                    style="width: {{ $cat->persentase }}%"></div>
            </div>
        </div>
        @empty
        <p class="text-muted small">Belum ada target kategori.</p>
    @endforelse
</div>
        
        
    </div>
</div>

<div class="card mt-4 overflow-hidden">
    <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0">Transaksi Terbaru</h5>
        <a href="#" class="text-success text-decoration-none fw-bold small">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 border-0">Tanggal</th>
                    <th class="border-0">Deskripsi</th>
                    <th class="border-0">Kategori</th>
                    <th class="border-0 text-end pe-4">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $t)
                <tr>
                    <td class="ps-4">{{ \Carbon\Carbon::parse($t->tanggal)->format('d M, Y') }}</td>
                    <td class="fw-semibold">{{ $t->deskripsi }}</td>
                    <td><span class="badge rounded-pill bg-light text-dark px-3">{{ $t->category->nama }}</span></td>
                    <td class="text-end pe-4 fw-bold {{ $t->tipe == 'masuk' ? 'text-success' : 'text-danger' }}">
                        {{ $t->tipe == 'masuk' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center p-4">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('outflowChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!}, // Data dari Controller
            datasets: [{
                label: 'Pengeluaran (Rp)',
                data: {!! json_encode($chartData) !!}, // Data dari Controller
                backgroundColor: '#10b981',
                borderRadius: 10,
                barThickness: 25
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { 
                y: { beginAtZero: true, grid: { borderDash: [5, 5], drawBorder: false } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush