<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// role & status_akses sengaja TIDAK di-fillable agar tidak bisa diubah lewat mass-assignment.
#[Fillable(['nama_lengkap', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'status_akses' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    public function laporanHarianSampah(): HasMany
    {
        return $this->hasMany(LaporanHarianSampah::class, 'id_user', 'id_user');
    }

    public function catatanTanaman(): HasMany
    {
        return $this->hasMany(CatatanTanaman::class, 'id_user', 'id_user');
    }
}
