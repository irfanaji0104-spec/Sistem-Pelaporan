<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_lokasi' => 'Lab Komputer 1',       'gedung' => 'Gedung A', 'lantai' => '1'],
            ['nama_lokasi' => 'Lab Komputer 2',       'gedung' => 'Gedung A', 'lantai' => '1'],
            ['nama_lokasi' => 'Lab Bahasa',           'gedung' => 'Gedung A', 'lantai' => '2'],
            ['nama_lokasi' => 'Ruang Kelas ASM 1',   'gedung' => 'Gedung B', 'lantai' => '1'],
            ['nama_lokasi' => 'Ruang Kelas ASM 2',   'gedung' => 'Gedung B', 'lantai' => '1'],
            ['nama_lokasi' => 'Ruang Kelas ASM 3',   'gedung' => 'Gedung B', 'lantai' => '1'],
            ['nama_lokasi' => 'Ruang Guru',           'gedung' => 'Gedung C', 'lantai' => '1'],
            ['nama_lokasi' => 'Perpustakaan',         'gedung' => 'Gedung C', 'lantai' => '2'],
            ['nama_lokasi' => 'Toilet Lt. 1',         'gedung' => 'Gedung A', 'lantai' => '1'],
            ['nama_lokasi' => 'Toilet Lt. 2',         'gedung' => 'Gedung A', 'lantai' => '2'],
            ['nama_lokasi' => 'Lapangan Basket',      'gedung' => 'Area Luar', 'lantai' => '-'],
            ['nama_lokasi' => 'Kantin',               'gedung' => 'Area Luar', 'lantai' => '-'],
            ['nama_lokasi' => 'Aula Sekolah',         'gedung' => 'Gedung D', 'lantai' => '1'],
        ];

        foreach ($data as $d) {
            Lokasi::updateOrCreate(['nama_lokasi' => $d['nama_lokasi']], $d);
        }
    }
}