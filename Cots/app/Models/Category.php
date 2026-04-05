<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'target', 'icon'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getPersentaseAttribute()
    {
        $totalPengeluaran = $this->transactions()
            ->where('tipe', 'keluar')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('jumlah');

        if ($this->target <= 0) return 0;

        $persen = ($totalPengeluaran / $this->target) * 100;
        return round($persen > 100 ? 100 : $persen);
    }
}