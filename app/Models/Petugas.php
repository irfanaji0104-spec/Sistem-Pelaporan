<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Petugas extends Model
{
    protected $table = 'petugas';
    protected $fillable = ['nama', 'kontak', 'spesialisasi'];

    public function pengaduan(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'petugas_id');
    }

    public function tugasAktif(): HasMany
    {
        return $this->pengaduan()->where('status', 'approved');
    }

    public function getInisialAttribute(): string
    {
        $parts = preg_split('/\s+/', trim($this->nama));
        $ini = '';
        foreach (array_slice($parts, 0, 2) as $p) {
            $ini .= mb_strtoupper(mb_substr($p, 0, 1));
        }
        return $ini ?: '?';
    }
}