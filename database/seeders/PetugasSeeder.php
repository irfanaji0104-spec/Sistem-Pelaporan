<?php

namespace Database\Seeders;

use App\Models\Petugas;
use Illuminate\Database\Seeder;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'Supardi',          'kontak' => '081234567890', 'spesialisasi' => 'Elektronik'],
            ['nama' => 'Wawan Setiawan',   'kontak' => '082345678901', 'spesialisasi' => 'Bangunan'],
            ['nama' => 'Rudi Hartono',     'kontak' => '083456789012', 'spesialisasi' => 'Sanitasi'],
            ['nama' => 'Agus Priyatno',    'kontak' => '084567890123', 'spesialisasi' => 'Listrik'],
            ['nama' => 'Bambang Irawan',   'kontak' => '085678901234', 'spesialisasi' => 'Elektronik'],
        ];

        foreach ($data as $d) {
            Petugas::updateOrCreate(['nama' => $d['nama']], $d);
        }
    }
}