<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Hitung Statistik Utama
        $totalIncome = Transaction::where('tipe', 'masuk')->sum('jumlah');
        $totalExpense = Transaction::where('tipe', 'keluar')->sum('jumlah');
        $netSavings = $totalIncome - $totalExpense;

        // 2. Ambil Kategori dengan total pengeluaran masing-masing (untuk Donut Chart)
        $categories = Category::withSum(['transactions as total_spent' => function($query) {
    $query->where('tipe', 'keluar'); // Hanya menghitung pengeluaran
}], 'jumlah')->get();

        // 3. Siapkan Data untuk Grafik Tren (12 Bulan)
        $incomeTrend = [];
        $expenseTrend = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        for ($m = 1; $m <= 12; $m++) {
            $incomeTrend[] = Transaction::where('tipe', 'masuk')
                ->whereMonth('tanggal', $m)
                ->whereYear('tanggal', date('Y'))
                ->sum('jumlah');

            $expenseTrend[] = Transaction::where('tipe', 'keluar')
                ->whereMonth('tanggal', $m)
                ->whereYear('tanggal', date('Y'))
                ->sum('jumlah');
        }

        return view('report', compact(
            'totalIncome', 
            'totalExpense', 
            'netSavings', 
            'categories', 
            'incomeTrend', 
            'expenseTrend', 
            'months'
        ));
    }
}