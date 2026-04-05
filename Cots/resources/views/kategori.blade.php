@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-0">Kategori</h2>
        <p class="text-muted">Kelola kategori pengeluaran akademik dan harianmu secara teratur.</p>
    </div>
    <button class="btn btn-success px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
        <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
    </button>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card p-4 border-start border-success border-4 shadow-sm">
            <small class="text-muted text-uppercase fw-bold">Total Kategori</small>
            <h3 class="fw-bold mt-2">{{ $totalKategori }} <span class="fs-6 fw-normal text-muted">Aktif</span></h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 border-start border-warning border-4 shadow-sm">
            <small class="text-muted text-uppercase fw-bold">Batas Bulanan</small>
            <h3 class="fw-bold mt-2">Rp {{ number_format($batasBulanan, 0, ',', '.') }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 border-start border-primary border-4 shadow-sm">
            <small class="text-muted text-uppercase fw-bold">Paling Sering</small>
            <h3 class="fw-bold mt-2">{{ $palingSering }}</h3>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light border-bottom text-muted">
                <tr>
                    <th class="ps-4 py-3 text-uppercase" style="font-size: 0.75rem;">Ikon & Nama</th>
                    <th class="py-3 text-uppercase" style="font-size: 0.75rem;">Status Anggaran</th>
                    <th class="py-3 text-uppercase" style="font-size: 0.75rem;">Target Bulanan</th>
                    <th class="py-3 text-center text-uppercase" style="font-size: 0.75rem;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-2 rounded-3 me-3 text-success">
                                <i class="bi {{ $cat->icon ?? 'bi-tag' }} fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ $cat->nama }}</div>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $cat->deskripsi }}</small>
                            </div>
                        </div>
                    </td>
                    <td style="width: 30%;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="progress flex-grow-1" style="height: 6px;">
                                <div class="progress-bar {{ $cat->persentase >= 90 ? 'bg-danger' : 'bg-success' }}" 
                                    style="width: {{ $cat->persentase }}%">
                                </div>
                            </div>
                            <small class="fw-bold text-success">{{ $cat->persentase }}%</small>
                        </div>
                    </td>
                    <td class="fw-bold">Rp {{ number_format($cat->target, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-link text-dark p-1"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm btn-link text-danger p-1"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formKategori">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Kategori</label>
                        <input type="text" name="nama" class="form-control bg-light border-0" placeholder="Misal: Makan & Minum" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Deskripsi Singkat</label>
                        <input type="text" name="deskripsi" class="form-control bg-light border-0" placeholder="Kebutuhan pangan harian">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Target Bulanan (Rp)</label>
                            <input type="number" name="target" class="form-control bg-light border-0" placeholder="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Ikon (Bootstrap Icon)</label>
                            <input type="text" name="icon" class="form-control bg-light border-0" placeholder="bi-cart">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 mt-3">Simpan Kategori</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#formKategori').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('kategori.store') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                if(response.success) {
                    $('#modalTambahKategori').modal('hide');
                    alert('Kategori berhasil ditambahkan!');
                    location.reload();
                }
            },
            error: function() { alert('Gagal menambah kategori.'); }
        });
    });
});
</script>
@endpush