<?php

namespace Database\Seeders;

use App\Models\BoardingHouse;
use App\Models\Category;
use App\Models\City;
use App\Models\User; // Pastikan User di-import jika user_id manual
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BoardingHouseSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada data City dan Category dulu (ambil random)
        $city = City::first() ?? City::factory()->create();
        $category = Category::first() ?? Category::factory()->create();
        
        // Ambil User sembarang untuk owner (atau buat baru jika kosong)
        $user = User::first() ?? User::factory()->create();

        BoardingHouse::create([
            'name' => 'Kost Eksklusif Mawar Melati',
            'slug' => Str::slug('Kost Eksklusif Mawar Melati'),
            'thumbnail' => 'boarding_houses/default-thumbnail.jpg', // Pastikan file ini ada atau ganti path
            'city_id' => $city->id,
            'category_id' => $category->id,
            'user_id' => $user->id, // Owner
            'description' => '<p>Kost nyaman, aman, dan strategis dekat pusat kota. Cocok untuk mahasiswa dan karyawan.</p>',
            'price' => 1500000,
            'address' => 'Jl. Mawar No. 123, Jakarta Selatan',
            'room_size' => '3x4',
            
            // --- BAGIAN PENTING: ARRAY, BUKAN STRING ---
            'room_facilities' => ['AC', 'Kasur Springbed', 'Meja Belajar', 'Lemari Pakaian', 'WiFi Kencang'],
            'bathroom_facilities' => ['Kamar Mandi Dalam', 'Water Heater', 'Shower', 'Kloset Duduk'],
            'rules' => ['Dilarang Merokok di Kamar', 'Tamu Maksimal Jam 10 Malam', 'Akses 24 Jam', 'Tidak Boleh Bawa Hewan'],
            // -------------------------------------------
        ]);

        BoardingHouse::create([
            'name' => 'Kost Putra Bangsa',
            'slug' => Str::slug('Kost Putra Bangsa'),
            'thumbnail' => 'boarding_houses/default-thumbnail-2.jpg',
            'city_id' => $city->id,
            'category_id' => $category->id,
            'user_id' => $user->id,
            'description' => '<p>Kost khusus putra dengan lingkungan tenang dan asri.</p>',
            'price' => 850000,
            'address' => 'Jl. Kebangsaan No. 45, Bandung',
            'room_size' => '3x3',
            'room_facilities' => ['Kasur Busa', 'Meja Lesehan', 'Lemari Kecil'],
            'bathroom_facilities' => ['Kamar Mandi Luar', 'Ember & Gayung'],
            'rules' => ['Gerbang Tutup Jam 11', 'Khusus Pria'],
        ]);
    }
}