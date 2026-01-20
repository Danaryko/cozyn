<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('boarding_houses', function (Blueprint $table) {
            // 1. Kita hapus dulu kolom lama yang tipe datanya salah/berisi string
            $table->dropColumn(['room_facilities', 'bathroom_facilities', 'rules']);
        });

        Schema::table('boarding_houses', function (Blueprint $table) {
            // 2. Kita buat ulang dengan tipe JSON yang benar
            $table->json('room_facilities')->nullable()->after('room_size');
            $table->json('bathroom_facilities')->nullable()->after('room_facilities');
            $table->json('rules')->nullable()->after('bathroom_facilities');
        });
    }

    public function down(): void
    {
        // Jaga-jaga kalau mau rollback, kembalikan ke text
        Schema::table('boarding_houses', function (Blueprint $table) {
            $table->dropColumn(['room_facilities', 'bathroom_facilities', 'rules']);
        });

        Schema::table('boarding_houses', function (Blueprint $table) {
            $table->text('room_facilities')->nullable();
            $table->text('bathroom_facilities')->nullable();
            $table->text('rules')->nullable();
        });
    }
};