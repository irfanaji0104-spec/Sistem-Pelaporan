<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lokasi extends Model
{
    protected $table = 'lokasi';
    protected $fillable = ['nama_lokasi', 'gedung', 'lantai'];

    public function pengaduan(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'lokasi_id');
    }

    public function getLabelLengkapAttribute(): string
    {
        $extra = array_filter([$this->gedung, $this->lantai ? 'Lt. '.$this->lantai : null]);
        return $this->nama_lokasi . ($extra ? ' (' . implode(' · ', $extra) . ')' : '');
    }
}