<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; margin-bottom: 5px; }
        p.sub { text-align: center; color: #666; margin-top: 0; margin-bottom: 20px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8fafc; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 10px; font-weight: bold; }
        .pending { background: #fef3c7; color: #92400e; }
        .approved { background: #dbeafe; color: #1e40af; }
        .selesai { background: #dcfce7; color: #166534; }
        .rejected { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <h2>Laporan Pengaduan Sarana Sekolah</h2>
    <p class="sub">SMK Negeri 5 Surakarta — Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pelapor</th>
                <th>Lokasi</th>
                <th>Kategori</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Waktu Selesai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $p)
                <tr>
                    <td>{{ $p->kode }}</td>
                    <td>{{ $p->user->name }} ({{ ucfirst($p->user->role) }})</td>
                    <td>{{ $p->lokasi->nama_lokasi }}</td>
                    <td>{{ $p->kategori->nama_kategori }}</td>
                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $p->status }}">{{ $p->status_label }}</span>
                    </td>
                    <td>{{ $p->waktu_selesai ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>