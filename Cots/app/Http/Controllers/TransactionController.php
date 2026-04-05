<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;

class TransactionController extends Controller
{
    public function index()
    {
      $categories = Category::all(); 
    // Ambil transaksi terbaru dengan relasi kategori
    $all_transactions = Transaction::with('category')->latest()->paginate(10);
    
    // Hitung Saldo Real-time
    $pemasukan = Transaction::where('tipe', 'masuk')->sum('jumlah');
    $pengeluaran = Transaction::where('tipe', 'keluar')->sum('jumlah');
    $saldo = $pemasukan - $pengeluaran;

    // Logika Budget (Misal: Batas 2 Juta per bulan)
    $limit = 2000000;
    $budget_used = $limit > 0 ? round(($pengeluaran / $limit) * 100) : 0;

    return view('transaksi', compact('all_transactions', 'saldo', 'budget_used', 'categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi data (Kategori sekarang menggunakan category_id)
        $validated = $request->validate([
            'deskripsi'   => 'required|string|max:255',
            'catatan'     => 'nullable|string|max:255',
            'jumlah'      => 'required|numeric|min:0',
            'tipe'        => 'required|in:masuk,keluar',
            'category_id' => 'required|exists:categories,id', // Pastikan ID kategori ada di tabel categories
            'tanggal'     => 'required|date',
        ]);

        // 2. Simpan ke database
        $transaction = Transaction::create($validated);

        // 3. Kirim respon JSON kembali ke jQuery
        return response()->json([
            'success' => true,
            'message' => 'Transaksi ' . $request->tipe . ' berhasil disimpan!',
            'data'    => $transaction
        ]);
    }
}