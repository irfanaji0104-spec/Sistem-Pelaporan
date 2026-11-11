<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';

    protected $fillable = [
        'user_id', 'kategori_id', 'lokasi_id', 'petugas_id',
        'deskripsi', 'foto_bukti', 'status', 'catatan_admin', 'tanggal_selesai',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_selesai' => 'datetime',
        ];
    }

    // === Relasi ===
    public function user(): BelongsTo         { return $this->belongsTo(User::class, 'user_id'); }
    public function kategori(): BelongsTo     { return $this->belongsTo(KategoriKerusakan::class, 'kategori_id'); }
    public function lokasi(): BelongsTo       { return $this->belongsTo(Lokasi::class, 'lokasi_id'); }
    public function petugas(): BelongsTo      { return $this->belongsTo(Petugas::class, 'petugas_id'); }
    public function riwayat(): HasMany        { return $this->hasMany(RiwayatStatus::class, 'pengaduan_id')->latest(); }

    // === Helpers ===
    public function getKodeAttribute(): string
    {
        return '#' . str_pad((string) $this->id, 3, '0', STR_PAD_LEFT);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'Pending',
            'approved' => 'Diproses',
            'selesai'  => 'Selesai',
            'rejected' => 'Rejected',
            default    => ucfirst($this->status),
        };
    }

    public function getStatusBadgeClassesAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
            'approved' => 'bg-blue-100 text-blue-800 border border-blue-200',
            'selesai'  => 'bg-green-100 text-green-800 border border-green-200',
            'rejected' => 'bg-red-100 text-red-800 border border-red-200',
            default    => 'bg-gray-100 text-gray-800 border border-gray-200',
        };
    }

    public function getWaktuSelesaiAttribute(): ?string
    {
        if (!$this->tanggal_selesai) return null;
        $diff = $this->tanggal_selesai->diff($this->created_at);
        if ($diff->d > 0) return $diff->d . ' hari';
        if ($diff->h > 0) return $diff->h . ' jam';
        return $diff->i . ' menit';
    }
}