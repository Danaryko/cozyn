<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\BoardingHouse;
use App\Models\City;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Setup User System
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@cozyn.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Anak Rantau (Penyewa)',
            'email' => 'user@cozyn.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // 2. Setup 5 Owner Spesifik
        $pakBudi = User::create([
            'name' => 'Pak Haji Budi',
            'email' => 'budi@cozyn.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]); // Pemilik Area Jakarta

        $buSiti = User::create([
            'name' => 'Ibu Siti Aminah',
            'email' => 'siti@cozyn.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]); // Pemilik Area Bandung

        $masAgung = User::create([
            'name' => 'Agung Juragan Kost',
            'email' => 'agung@cozyn.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]); // Pemilik Area Jogja & Malang

        $bliWayan = User::create([
            'name' => 'Bli Wayan',
            'email' => 'wayan@cozyn.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]); // Pemilik Area Bali

        $buRatna = User::create([
            'name' => 'Ibu Ratna BSD',
            'email' => 'ratna@cozyn.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]); // Pemilik Area Tangsel & Surabaya

        // 3. Setup Kota
        $jakarta = City::create(['name' => 'Jakarta', 'slug' => 'jakarta', 'image' => 'images/city1.jpg']);
        $bandung = City::create(['name' => 'Bandung', 'slug' => 'bandung', 'image' => 'images/city2.jpg']);
        $jogja   = City::create(['name' => 'Yogyakarta', 'slug' => 'yogyakarta', 'image' => 'images/city3.jpg']);
        $malang  = City::create(['name' => 'Malang', 'slug' => 'malang', 'image' => 'images/city4.jpg']);
        $bali    = City::create(['name' => 'Bali', 'slug' => 'bali', 'image' => 'images/city5.jpg']);
        $tangsel = City::create(['name' => 'Tangerang Selatan', 'slug' => 'tangerang-selatan', 'image' => 'images/city6.jpg']);
        $surabaya= City::create(['name' => 'Surabaya', 'slug' => 'surabaya', 'image' => 'images/city7.jpg']);

        // 4. Setup Kategori
        $catCampur = Category::create(['name' => 'Kost Campur', 'slug' => 'kost-campur', 'image' => 'images/cat1.jpg']);
        $catPutra  = Category::create(['name' => 'Kost Putra', 'slug' => 'kost-putra', 'image' => 'images/cat2.jpg']);
        $catPutri  = Category::create(['name' => 'Kost Putri', 'slug' => 'kost-putri', 'image' => 'images/cat3.jpg']);
        $catEksklusif = Category::create(['name' => 'Apartment / Eksklusif', 'slug' => 'kost-eksklusif', 'image' => 'images/cat4.jpg']);

        // 5. Input Data Kost (Mapping Manual: Owner -> Kota)

        // --- PAK BUDI (JAKARTA) ---
        BoardingHouse::create([
            'user_id' => $pakBudi->id, 'city_id' => $jakarta->id, 'category_id' => $catEksklusif->id,
            'name' => 'Rukita Jack House Melawai', 'slug' => 'rukita-jack-house',
            'price' => 3800000, 'address' => 'Jl. Melawai X No.6, Kebayoran Baru',
            'description' => 'Kost coliving modern di area Blok M.',
            'thumbnail' => 'thumbnails/default.jpg',
        ]);
        BoardingHouse::create([
            'user_id' => $pakBudi->id, 'city_id' => $jakarta->id, 'category_id' => $catCampur->id,
            'name' => 'Tanjung Duren Residence', 'slug' => 'tanjung-duren-residence',
            'price' => 1900000, 'address' => 'Jl. Tanjung Duren Utara 4',
            'description' => 'Favorit mahasiswa Binus & Untar.',
            'thumbnail' => 'thumbnails/default.jpg',
        ]);
        BoardingHouse::create([
            'user_id' => $pakBudi->id, 'city_id' => $jakarta->id, 'category_id' => $catPutri->id,
            'name' => 'Kost 45 Tebet', 'slug' => 'kost-45-tebet',
            'price' => 2200000, 'address' => 'Jl. Tebet Timur Dalam Raya',
            'description' => 'Kost putri strategis dekat Stasiun Tebet.',
            'thumbnail' => 'thumbnails/default.jpg',
        ]);

        // --- BU SITI (BANDUNG) ---
        BoardingHouse::create([
            'user_id' => $buSiti->id, 'city_id' => $bandung->id, 'category_id' => $catEksklusif->id,
            'name' => 'D\'Paragon Dago', 'slug' => 'dparagon-dago',
            'price' => 2500000, 'address' => 'Jl. Cisitu Indah, Dago',
            'description' => 'Kost eksklusif rasa hotel. View bukit Dago.',
            'thumbnail' => 'thumbnails/default.jpg',
        ]);
        BoardingHouse::create([
            'user_id' => $buSiti->id, 'city_id' => $bandung->id, 'category_id' => $catPutri->id,
            'name' => 'Wisma Pitaloka Dipatiukur', 'slug' => 'wisma-pitaloka',
            'price' => 1600000, 'address' => 'Jl. Dipatiukur No. 88',
            'description' => 'Sangat dekat dengan UNPAD dan ITHB.',
            'thumbnail' => 'thumbnails/default.jpg',
        ]);
        BoardingHouse::create([
            'user_id' => $buSiti->id, 'city_id' => $bandung->id, 'category_id' => $catPutra->id,
            'name' => 'Pondok Esek Gerlong', 'slug' => 'pondok-esek',
            'price' => 950000, 'address' => 'Gegerkalong Girang',
            'description' => 'Kost legendaris mahasiswa UPI & DT.',
            'thumbnail' => 'thumbnails/default.jpg',
        ]);

        // --- MAS AGUNG (JOGJA & MALANG) ---
        BoardingHouse::create([
            'user_id' => $masAgung->id, 'city_id' => $jogja->id, 'category_id' => $catEksklusif->id,
            'name' => 'D\'Paragon Seturan 2', 'slug' => 'dparagon-seturan',
            'price' => 2100000, 'address' => 'Perumnas Seturan, Depok',
            'description' => 'Kost eksklusif jaringan nasional.',
            'thumbnail' => 'thumbnails/default.jpg',
        ]);
        BoardingHouse::create([
            'user_id' => $masAgung->id, 'city_id' => $malang->id, 'category_id' => $catPutri->id,
            'name' => 'Griya Brawijaya', 'slug' => 'griya-brawijaya',
            'price' => 1200000, 'address' => 'Kampus UB, Jl. Veteran',
            'description' => 'Asrama resmi Universitas Brawijaya.',
            'thumbnail' => 'thumbnails/default.jpg',
        ]);

         // --- BLI WAYAN (BALI) ---
         BoardingHouse::create([
            'user_id' => $bliWayan->id, 'city_id' => $bali->id, 'category_id' => $catEksklusif->id,
            'name' => 'Matra Co-Living Canggu', 'slug' => 'matra-canggu',
            'price' => 5500000, 'address' => 'Jl. Raya Semat, Canggu',
            'description' => 'Surga digital nomad.',
            'thumbnail' => 'thumbnails/default.jpg',
        ]);
        BoardingHouse::create([
            'user_id' => $bliWayan->id, 'city_id' => $bali->id, 'category_id' => $catCampur->id,
            'name' => 'Bali True Living', 'slug' => 'bali-true-living',
            'price' => 3200000, 'address' => 'Jl. Imam Bonjol, Denpasar',
            'description' => 'Apartment style.',
            'thumbnail' => 'thumbnails/default.jpg',
        ]);

        // --- BU RATNA (TANGSEL & SURABAYA) ---
        BoardingHouse::create([
            'user_id' => $buRatna->id, 'city_id' => $tangsel->id, 'category_id' => $catEksklusif->id,
            'name' => 'Rukita Urban Intermoda BSD', 'slug' => 'rukita-intermoda',
            'price' => 2900000, 'address' => 'Dekat Pasar Modern Intermoda',
            'description' => 'Akses langsung Stasiun Cisauk.',
            'thumbnail' => 'thumbnails/default.jpg',
        ]);
        BoardingHouse::create([
            'user_id' => $buRatna->id, 'city_id' => $surabaya->id, 'category_id' => $catPutri->id,
            'name' => 'Kost Putri ITS Gebang', 'slug' => 'putri-its',
            'price' => 850000, 'address' => 'Gebang Putih, Sukolilo',
            'description' => 'Sangat dekat dengan gerbang belakang ITS.',
            'thumbnail' => 'thumbnails/default.jpg',
        ]);
    }
}