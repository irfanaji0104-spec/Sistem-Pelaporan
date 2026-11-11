<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriKerusakan extends Model
{
    protected $table = 'kategori_kerusakan';
    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function pengaduan(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'kategori_id');
    }
}