@extends('layouts.app')

@section('title', 'Buku Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h2 class="fw-bold mb-0">Buku Transaksi</h2>
        <p class="text-muted">Pantau pengeluaran gaya hidup akademik dan beasiswamu secara rinci.</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-light border shadow-sm px-3"><i class="bi bi-filter me-2"></i>Filter</button>
        <button class="btn btn-success px-3 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambah">
    <i class="bi bi-plus-lg me-2"></i>Tambah Transaksi
</button>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-7">
        <div class="card p-4 d-flex flex-row align-items-center justify-content-between">
            <div>
                <small class="text-muted text-uppercase fw-bold">Saldo Saat Ini</small>
                <h2 class="fw-bold mb-0 mt-1">Rp {{ number_format($saldo, 2, ',', '.') }}</h2>
            </div>
            <div class="bg-success bg-opacity-10 p-3 rounded-4">
                <i class="bi bi-wallet2 text-success fs-3"></i>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card p-4">
            <div class="d-flex justify-content-between mb-2">
                <small class="text-muted text-uppercase fw-bold">Batas Bulanan</small>
                <small class="text-success fw-bold">{{ $budget_used }}% Terpakai</small>
            </div>
            <div class="progress mb-2" style="height: 10px;">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $budget_used }}%"></div>
            </div>
            <small class="text-muted" style="font-size: 0.75rem;">Berakhir dalam 12 hari. Kamu hemat Rp 120rb dibanding bulan lalu.</small>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 overflow-hidden">
    <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-white">
        <h5 class="fw-bold mb-0">Aktivitas Terbaru</h5>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-light border text-muted px-3">Semua Waktu</button>
            <button class="btn btn-sm btn-light border text-muted px-3">Ekspor CSV</button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light border-bottom text-muted">
                <tr>
                    <th class="ps-4 py-3" style="font-size: 0.8rem; letter-spacing: 0.5px;">TANGGAL</th>
                    <th class="py-3" style="font-size: 0.8rem; letter-spacing: 0.5px;">DESKRIPSI</th>
                    <th class="py-3" style="font-size: 0.8rem; letter-spacing: 0.5px;">KATEGORI</th>
                    <th class="py-3" style="font-size: 0.8rem; letter-spacing: 0.5px;">TIPE</th>
                    <th class="py-3 text-end" style="font-size: 0.8rem; letter-spacing: 0.5px;">JUMLAH</th>
                    <th class="py-3 text-center" style="font-size: 0.8rem; letter-spacing: 0.5px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($all_transactions as $t)
<tr>
    <td class="ps-4 text-muted small">
        {{ \Carbon\Carbon::parse($t->tanggal)->translatedFormat('d M, Y') }}
    </td>
    <td>
        <div class="fw-bold mb-0 text-dark">{{ $t->deskripsi }}</div>
        {{-- Menampilkan catatan sebagai subtitle --}}
        <small class="text-muted" style="font-size: 0.75rem;">
            {{ $t->catatan ?? 'Tidak ada catatan' }}
        </small>
    </td>
    <td>
        <span class="badge rounded-pill bg-info bg-opacity-10 text-info border-info px-3 py-2 small">
            {{ $t->category->nama ?? 'Umum' }}
        </span>
    </td>
    <td>
        @if($t->tipe == 'masuk')
            <span class="text-success small fw-bold"><i class="bi bi-arrow-up-right me-1"></i>Pemasukan</span>
        @else
            <span class="text-danger small fw-bold"><i class="bi bi-arrow-down-right me-1"></i>Pengeluaran</span>
        @endif
    </td>
    <td class="text-end fw-bold {{ $t->tipe == 'masuk' ? 'text-success' : 'text-dark' }}">
        {{ $t->tipe == 'masuk' ? '+' : '-' }}Rp {{ number_format($t->jumlah, 0, ',', '.') }}
    </td>
    <td class="text-center">
        <button class="btn btn-sm btn-light border p-1 px-2"><i class="bi bi-three-dots"></i></button>
    </td>
</tr>
@endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 bg-white border-top d-flex justify-content-between align-items-center">
        <small class="text-muted">Menampilkan {{ $all_transactions->firstItem() }} ke {{ $all_transactions->lastItem() }} dari {{ $all_transactions->total() }} transaksi</small>
        <div>
            {{ $all_transactions->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold mb-0">Tambah Transaksi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formTransaksi">
    @csrf
    <input type="hidden" name="tipe" id="tipe_transaksi" value="keluar">

    <div class="row g-2 mb-4">
        <div class="col-6">
            <button type="button" id="btn-expense" class="btn btn-danger w-100 py-3 fw-bold shadow-sm border-0 active-expense">
                <i class="bi bi-arrow-up-right me-2"></i> Pengeluaran
            </button>
        </div>
        <div class="col-6">
            <button type="button" id="btn-income" class="btn btn-outline-secondary w-100 py-3 fw-bold border-0 bg-light text-muted">
                <i class="bi bi-arrow-down-left me-2"></i> Pemasukan
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label small fw-bold text-muted">Jumlah (Rp)</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0 text-muted">Rp</span>
                <input type="number" name="jumlah" class="form-control bg-light border-0 py-2" placeholder="0.00" required>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label small fw-bold text-muted">Kategori</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-grid-1x2"></i></span>
                <select name="category_id" class="form-select bg-light border-0 py-2" required>
                    <option value="" selected disabled>Pilih kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label small fw-bold text-muted">Tanggal Transaksi</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-event"></i></span>
                <input type="date" name="tanggal" class="form-control bg-light border-0 py-2" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label small fw-bold text-muted">Deskripsi</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-chat-left-text"></i></span>
                <input type="text" name="deskripsi" class="form-control bg-light border-0 py-2" placeholder="Contoh: Beli buku kuliah" required>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
        <button type="button" class="btn btn-light px-4 fw-bold text-muted" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success px-4 fw-bold shadow-sm">
            <i class="bi bi-save me-2"></i> Simpan Transaksi
        </button>
    </div>
</form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    const btnExpense = $('#btn-expense');
    const btnIncome = $('#btn-income');
    const inputTipe = $('#tipe_transaksi');

    // Klik Pengeluaran
    btnExpense.on('click', function() {
        inputTipe.val('keluar');
        btnExpense.addClass('active-expense').removeClass('btn-outline-secondary text-muted');
        btnIncome.removeClass('active-income').addClass('btn-outline-secondary bg-light text-muted');
    });

    // Klik Pemasukan
    btnIncome.on('click', function() {
        inputTipe.val('masuk');
        btnIncome.addClass('active-income').removeClass('btn-outline-secondary text-muted');
        btnExpense.removeClass('active-expense').addClass('btn-outline-secondary bg-light text-muted');
    });

    // Handle pengiriman form via AJAX
    $('#formTransaksi').on('submit', function(e) {
        e.preventDefault();
        
        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('transaksi.store') }}",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if(response.success) {
                    $('#modalTambah').modal('hide');
                    $('#formTransaksi')[0].reset();
                    alert('Transaksi berhasil disimpan!');
                    location.reload();
                }
            },
           error: function(xhr) {
            let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem';
            alert('Gagal simpan: ' + errorMessage);
            console.log(xhr.responseText); 
        }
        });
    });
});
</script>
@endpush