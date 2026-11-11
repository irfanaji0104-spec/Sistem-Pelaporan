<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_induk',
        'foto_profil',
        'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // === Helpers ===
    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isSiswa(): bool   { return $this->role === 'siswa'; }
    public function isGuru(): bool    { return $this->role === 'guru'; }
    public function isPelapor(): bool { return in_array($this->role, ['siswa', 'guru'], true); }

    public function getLabelNoIndukAttribute(): string
    {
        return match ($this->role) {
            'siswa' => 'NIS',
            'guru'  => 'NIP',
            default => 'NIP',
        };
    }

    public function getInisialAttribute(): string
    {
        $parts = preg_split('/\s+/', trim($this->name));
        $ini = '';
        foreach (array_slice($parts, 0, 2) as $p) {
            $ini .= mb_strtoupper(mb_substr($p, 0, 1));
        }
        return $ini ?: '?';
    }

    // === Relasi ===
    public function pengaduan(): HasMany
    {
        return $this->hasMany(Pengaduan::class, 'user_id');
    }

    public function riwayatStatus(): HasMany
    {
        return $this->hasMany(RiwayatStatus::class, 'diubah_oleh');
    }
}