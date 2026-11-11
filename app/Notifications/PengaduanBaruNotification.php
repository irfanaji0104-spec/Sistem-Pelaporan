<?php

namespace App\Notifications;

use App\Models\Pengaduan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengaduanBaruNotification extends Notification
{
    use Queueable;

    public function __construct(public Pengaduan $pengaduan)
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
            'pesan'        => "Pengaduan baru dari {$this->pengaduan->user->name} ({$this->pengaduan->lokasi->nama_lokasi}).",
            'url'          => route('admin.verifikasi.show', $this->pengaduan->id),
        ];
    }
}