<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('boarding_houses', function (Blueprint $table) {
            // Kita tambahkan kolom baru disini
            $table->text('general_facilities')->nullable()->after('bathroom_facilities');
            $table->text('parking_facilities')->nullable()->after('general_facilities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boarding_houses', function (Blueprint $table) {
            // Hapus kolom jika rollback
            $table->dropColumn(['general_facilities', 'parking_facilities']);
        });
    }
};