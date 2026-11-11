<?php

namespace Database\Seeders;

use App\Models\KategoriKerusakan;
use App\Models\Lokasi;
use App\Models\Pengaduan;
use App\Models\Petugas;
use App\Models\RiwayatStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class PengaduanSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $siswa = User::where('role', 'siswa')->get();
        $guru  = User::where('role', 'guru')->get();
        $all   = $siswa->merge($guru);

        $kategori = KategoriKerusakan::all();
        $lokasi   = Lokasi::all();
        $petugas  = Petugas::all();

        // ============================================================
        // 12 pengaduan random (ID 1–12)
        // ============================================================
        for ($i = 0; $i < 12; $i++) {
            $user = $all->random();
            $kat  = $kategori->random();
            $lok  = $lokasi->random();
            $status = collect(['pending', 'approved', 'selesai', 'rejected'])->random();
            $pet = in_array($status, ['approved', 'selesai']) ? $petugas->random() : null;

            $p = Pengaduan::create([
                'user_id'         => $user->id,
                'kategori_id'     => $kat->id,
                'lokasi_id'       => $lok->id,
                'petugas_id'      => $pet?->id,
                'deskripsi'       => 'Kerusakan ' . strtolower($kat->nama_kategori) . ' di ' . $lok->nama_lokasi . '. Mohon segera ditindaklanjuti.',
                'status'          => $status,
                'catatan_admin'   => $status === 'rejected' ? 'Kerusakan tidak dapat diverifikasi, mohon ajukan ulang dengan bukti yang lebih jelas.' : null,
                'tanggal_selesai' => $status === 'selesai' ? now()->subDays(rand(1, 5)) : null,
                'created_at'      => now()->subDays(rand(6, 60)),
                'updated_at'      => now(),
            ]);

            $this->seedRiwayat($p, $admin->id, $status);
        }

        // ============================================================
        // 8 pengaduan sesuai Figma — paksa ID 94..101
        // ============================================================
               $figma = [
            // [id, pelapor_email, lokasi, kategori, tanggal(created_at), status, petugas_nama, tgl_selesai_hari, catatan]
            [101, 'andi.s@smkn5ska.sch.id',  'Lab Komputer 2',       'Elektronik',         '2026-08-28', 'pending',  null,             null, null],
            [100, 'sari@smkn5ska.sch.id',    'Ruang Guru',           'Furnitur',           '2026-08-27', 'pending',  null,             null, null],
            [ 99, 'dedi.p@smkn5ska.sch.id',  'Toilet Lt. 2',         'Sanitasi',           '2026-08-25', 'approved', 'Rudi Hartono',   null, null],
            [ 98, 'nia@smkn5ska.sch.id',     'Lab Bahasa',           'Elektronik',         '2026-08-24', 'selesai',  'Supardi',        2,    null],
            [ 97, 'siti.a@smkn5ska.sch.id',  'Lapangan Basket',      'Fasilitas Olahraga', '2026-08-22', 'rejected', null,             null, 'Fasilitas masih dalam perbaikan pihak ketiga.'],
            [ 96, 'rian.f@smkn5ska.sch.id',  'Ruang Kelas ASM 1',    'Furnitur',           '2026-08-20', 'selesai',  'Wawan Setiawan', 3,    null],
            [ 95, 'budi@smkn5ska.sch.id',    'Perpustakaan',         'Elektronik',         '2026-08-19', 'approved', 'Bambang Irawan', null, null],
            [ 94, 'mega.w@smkn5ska.sch.id',  'Ruang Kelas ASM 2',    'Furnitur',           '2026-08-15', 'selesai',  'Wawan Setiawan', 1,    null],
            [ 93, 'andi.s@smkn5ska.sch.id',  'Ruang Kelas ASM 3',    'Furnitur',           '2026-08-14', 'pending',  null,             null, null],
        ];

        foreach ($figma as [$id, $email, $lokName, $katName, $tgl, $status, $petName, $hariSelesai, $catatan]) {
            $user = User::where('email', $email)->first();
            $lok  = Lokasi::where('nama_lokasi', $lokName)->first();
            $kat  = KategoriKerusakan::where('nama_kategori', $katName)->first();
            $pet  = $petName ? Petugas::where('nama', $petName)->first() : null;

            $created = \Carbon\Carbon::parse($tgl . ' 09:00:00');
            $selesai = $hariSelesai ? (clone $created)->addDays($hariSelesai) : null;

            $p = Pengaduan::create([
                'id'              => $id,
                'user_id'         => $user->id,
                'kategori_id'     => $kat->id,
                'lokasi_id'       => $lok->id,
                'petugas_id'      => $pet?->id,
                'deskripsi'       => 'Kerusakan ' . strtolower($katName) . ' di ' . $lokName . '. Mohon segera ditindaklanjuti.',
                'status'          => $status,
                'catatan_admin'   => $catatan,
                'tanggal_selesai' => $selesai,
                'created_at'      => $created,
                'updated_at'      => now(),
            ]);

            $this->seedRiwayat($p, $admin->id, $status, $created, $selesai, $catatan, $petName);
        }
    }

    /**
     * Buat baris riwayat_status sesuai alur status.
     */
    private function seedRiwayat(
        Pengaduan $p,
        int $adminId,
        string $status,
        ?\Carbon\Carbon $created = null,
        ?\Carbon\Carbon $selesai = null,
        ?string $catatan = null,
        ?string $petName = null
    ): void {
        $t = $created ?? $p->created_at;
        $pelaporId = $p->user_id;

        // 1) Selalu ada baris pending dari pelapor
        RiwayatStatus::create([
            'pengaduan_id'      => $p->id,
            'diubah_oleh'       => $pelaporId,
            'status_sebelumnya' => null,
            'status_baru'       => 'pending',
            'keterangan'        => 'Pengaduan dibuat oleh pelapor.',
            'created_at'        => $t,
            'updated_at'        => $t,
        ]);

        if ($status === 'pending') return;

        // 2) Baris approved / rejected dari admin
        if (in_array($status, ['approved', 'selesai'])) {
            RiwayatStatus::create([
                'pengaduan_id'      => $p->id,
                'diubah_oleh'       => $adminId,
                'status_sebelumnya' => 'pending',
                'status_baru'       => 'approved',
                'keterangan'        => 'Pengaduan divalidasi' . ($petName ? " dan ditugaskan ke {$petName}." : '.'),
                'created_at'        => (clone $t)->addDay(),
                'updated_at'        => (clone $t)->addDay(),
            ]);
        }

        if ($status === 'rejected') {
            RiwayatStatus::create([
                'pengaduan_id'      => $p->id,
                'diubah_oleh'       => $adminId,
                'status_sebelumnya' => 'pending',
                'status_baru'       => 'rejected',
                'keterangan'        => $catatan ?? 'Pengaduan ditolak.',
                'created_at'        => (clone $t)->addDay(),
                'updated_at'        => (clone $t)->addDay(),
            ]);
        }

        // 3) Baris selesai
        if ($status === 'selesai' && $selesai) {
            RiwayatStatus::create([
                'pengaduan_id'      => $p->id,
                'diubah_oleh'       => $adminId,
                'status_sebelumnya' => 'approved',
                'status_baru'       => 'selesai',
                'keterangan'        => 'Perbaikan selesai.',
                'created_at'        => $selesai,
                'updated_at'        => $selesai,
            ]);
        }
    }
}