<?php

namespace Database\Seeders;

use App\Models\KategoriKerusakan;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_kategori' => 'Elektronik',          'deskripsi' => 'Kerusakan perangkat elektronik seperti komputer, proyektor, dan AC.'],
            ['nama_kategori' => 'Furnitur',            'deskripsi' => 'Kerusakan meja, kursi, lemari, dan perabot sekolah.'],
            ['nama_kategori' => 'Sanitasi',            'deskripsi' => 'Kerusakan pada toilet, wastafel, kran air, dan saluran air.'],
            ['nama_kategori' => 'Fasilitas Olahraga',  'deskripsi' => 'Kerusakan sarana olahraga seperti ring basket, gawang, dan net.'],
            ['nama_kategori' => 'Listrik',             'deskripsi' => 'Kerusakan lampu, saklar, stop kontak, dan instalasi listrik.'],
            ['nama_kategori' => 'Keamanan',            'deskripsi' => 'Kerusakan pintu, kunci, pagar, dan CCTV.'],
            ['nama_kategori' => 'Kebersihan',          'deskripsi' => 'Masalah kebersihan seperti sampah menumpuk dan saluran mampet.'],
            ['nama_kategori' => 'Lainnya',             'deskripsi' => 'Kerusakan lain yang tidak termasuk kategori di atas.'],
        ];

        foreach ($data as $d) {
            KategoriKerusakan::updateOrCreate(['nama_kategori' => $d['nama_kategori']], $d);
        }
    }
}