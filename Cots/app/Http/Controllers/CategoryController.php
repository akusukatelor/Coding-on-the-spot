<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Transaction;

class CategoryController extends Controller
{
    
    public function index()
    {
        $categories = Category::all();
        $totalKategori = $categories->count();
        $batasBulanan = $categories->sum('target');

      
        $mostFrequentId = Transaction::select('category_id')
            ->groupBy('category_id')
            ->orderByRaw('COUNT(*) DESC')
            ->first();

        $palingSering = '-';
        if ($mostFrequentId) {
            $cat = Category::find($mostFrequentId->category_id);
            $palingSering = $cat ? $cat->nama : '-';
        }

        return view('kategori', compact('categories', 'totalKategori', 'batasBulanan', 'palingSering'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:255',
            'target' => 'required|numeric',
            'icon' => 'nullable|string|max:50',
        ]);


        if (!$request->icon) {
            $validated['icon'] = 'bi-tag';
        }

        $category = Category::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan!',
            'data' => $category
        ]);
    }
}
