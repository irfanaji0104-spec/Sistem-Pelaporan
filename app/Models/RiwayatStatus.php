<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatStatus extends Model
{
    protected $table = 'riwayat_status';

    protected $fillable = [
        'pengaduan_id', 'diubah_oleh',
        'status_sebelumnya', 'status_baru', 'keterangan',
    ];

    public function pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diubah_oleh');
    }

    public function getStatusBaruLabelAttribute(): string
    {
        return match ($this->status_baru) {
            'pending'  => 'Pending',
            'approved' => 'Diproses',
            'selesai'  => 'Selesai',
            'rejected' => 'Rejected',
            default    => ucfirst($this->status_baru),
        };
    }
}