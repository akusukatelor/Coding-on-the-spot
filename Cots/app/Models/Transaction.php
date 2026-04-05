<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['deskripsi', 'catatan', 'jumlah', 'tipe', 'category_id', 'tanggal'];

    // Relasi balik ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
