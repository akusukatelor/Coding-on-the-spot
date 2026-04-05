<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama
        $pemasukan = Transaction::where('tipe', 'masuk')->sum('jumlah');
        $pengeluaran = Transaction::where('tipe', 'keluar')->sum('jumlah');
        $saldo = $pemasukan - $pengeluaran;

        // 2. Transaksi Terbaru (Eager Loading Kategori)
        $transaksi = Transaction::with('category')->latest()->take(5)->get();

        // 3. Target Anggaran (Ambil 2 kategori dengan persentase tertinggi)
        // Kita gunakan accessor 'persentase' yang sudah kita buat di Model Category
        $budgetCategories = Category::all()->sortByDesc(function($category) {
            return $category->persentase;
        })->take(2);

        // 4. Data untuk Grafik (6 Bulan Terakhir)
        $chartData = [];
        $chartLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->format('M');
            $chartData[] = Transaction::where('tipe', 'keluar')
                ->whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->sum('jumlah');
        }

        return view('dashboard', compact(
            'saldo', 'pemasukan', 'pengeluaran', 'transaksi', 
            'budgetCategories', 'chartData', 'chartLabels'
        ));
    }
}