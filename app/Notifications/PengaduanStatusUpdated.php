<?php

namespace App\Notifications;

use App\Models\Pengaduan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengaduanStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(public Pengaduan $pengaduan, public string $pesan)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'pengaduan_id' => $this->pengaduan->id,
            'kode'         => $this->pengaduan->kode,
            'status'       => $this->pengaduan->status,
            'pesan'        => $this->pesan,
            'url'          => route('pelapor.pengaduan.show', $this->pengaduan->id),
        ];
    }
}