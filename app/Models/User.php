<?php

namespace App\Models;

// 1. Pastikan import interface ini ada
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 2. Tambahkan "implements FilamentUser"
class User extends Authenticatable implements FilamentUser
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Pastikan kolom role ada di sini
        'avatar',
    ];

    // ... (codingan hidden/casts biarkan saja)

    // 3. TAMBAHKAN FUNGSI "SATPAM" INI
    public function canAccessPanel(Panel $panel): bool
    {
        // Jika user adalah 'admin', boleh masuk kemana saja (Opsional)
        if ($this->role === 'admin') {
            return true;
        }

        // Jika mau masuk panel 'owner', role harus 'owner'
        if ($panel->getId() === 'owner') {
            return $this->role === 'owner';
        }

        // Jika mau masuk panel 'admin', role harus 'admin'
        if ($panel->getId() === 'admin') {
            return $this->role === 'admin';
        }

        // Selain itu, tolak akses (return false)
        return false;
    }
}