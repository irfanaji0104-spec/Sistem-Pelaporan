<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        $users = [
            // Admin
            ['name' => 'Bu Ratna', 'email' => 'bu.ratna@smkn5ska.sch.id', 'role' => 'admin', 'no_induk' => 'ADM-001', 'is_active' => true],

            // Guru
            ['name' => 'Bu Sari',  'email' => 'sari@smkn5ska.sch.id',  'role' => 'guru',  'no_induk' => '198501012010012001', 'is_active' => true],
            ['name' => 'Bu Nia',   'email' => 'nia@smkn5ska.sch.id',   'role' => 'guru',  'no_induk' => '198703152011012002', 'is_active' => true],
            ['name' => 'Pak Budi', 'email' => 'budi@smkn5ska.sch.id',  'role' => 'guru',  'no_induk' => '198205202009011003', 'is_active' => true],

            // Siswa
            ['name' => 'Siti Amalia',       'email' => 'siti.a@smkn5ska.sch.id',  'role' => 'siswa', 'no_induk' => '22102', 'is_active' => true],
            ['name' => 'Rian Firmansyah',   'email' => 'rian.f@smkn5ska.sch.id',  'role' => 'siswa', 'no_induk' => '22104', 'is_active' => true],
            ['name' => 'Siswa Baru',   'email' => 'siswa@smkn5ska.sch.id',  'role' => 'siswa', 'no_induk' => '12345', 'is_active' => true],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                array_merge($u, ['password' => $password])
            );
        }
    }
}