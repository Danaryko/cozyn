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
            $table->string('room_size')->nullable(); 
            $table->json('room_facilities')->nullable(); 
            $table->json('bathroom_facilities')->nullable(); 
            $table->json('rules')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boarding_houses', function (Blueprint $table) {
            $table->dropColumn([
                'room_size', 
                'room_facilities', 
                'bathroom_facilities', 
                'rules'
            ]);
        });
    }
};