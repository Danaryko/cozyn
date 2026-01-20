<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;

class RoomPolicy
{
    /**
     * INI YANG PALING PENTING!
     * viewAny = Izin untuk melihat daftar (Tabel)
     */
    public function viewAny(User $user): bool
    {
        return true; // <--- WAJIB TRUE
    }

    public function view(User $user, Room $room): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true; // <--- Agar tombol "New Room" muncul
    }

    public function update(User $user, Room $room): bool
    {
        return true;
    }

    public function delete(User $user, Room $room): bool
    {
        return true;
    }
}