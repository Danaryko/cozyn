<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {   
        // a. Akun Owner (Pemilik Kos)
        $owner = User::create([
            'name' => 'Bapak Kos',
            'email' => 'owner@cozyn.com',
            'password' => Hash::make('password'),
            'role' => 'owner', // Pastikan di tabel users ada kolom 'role'
            // 'phone_number' => '08123456789', // Uncomment jika ada kolom no hp
        ]);

        // b. Akun User (Pencari Kos)
        User::create([
            'name' => 'Anak Rantau',
            'email' => 'user@cozyn.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // c. Akun Admin (Opsional)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@cozyn.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. BUAT DATA KOS (Dummy Data)
        // Kita hubungkan data kos ini dengan $owner yang baru dibuat di atas

        // Cek dulu apakah model Kost ada, untuk menghindari error jika belum dibuat
        if (class_exists(Kost::class)) {
            
            Kost::create([
                'user_id' => $owner->id, // Relasi ke pemilik
                'name' => 'Cozyn Residence BSD',
                'slug' => 'cozyn-residence-bsd',
                'type' => 'Campur', // Putra/Putri/Campur
                'address' => 'Jl. Anggrek Loka No. 20, BSD City',
                'description' => 'Kost nyaman, aman, free wifi 100mbps, kamar mandi dalam.',
                'price' => 1500000,
                'is_available' => true,
                // 'image' => 'images/kost1.jpg', // Sesuaikan jika ada upload gambar
            ]);

            Kost::create([
                'user_id' => $owner->id,
                'name' => 'Wisma Cozyn Melati',
                'slug' => 'wisma-cozyn-melati',
                'type' => 'Putri',
                'address' => 'Jl. Melati Putih, Jakarta Barat',
                'description' => 'Khusus putri, dekat kampus Binus, akses 24 jam.',
                'price' => 850000,
                'is_available' => true,
            ]);
        }
    }
}