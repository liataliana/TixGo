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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('airline');              // Nama maskapai
            $table->string('origin');               // Kota asal
            $table->string('destination');          // Kota tujuan
            $table->timestamp('departure_time');    // Waktu keberangkatan
            $table->timestamp('arrival_time');      // Waktu kedatangan
            $table->decimal('price', 12, 2);        // Harga tiket
            $table->integer('capacity');            // Kapasitas total
            $table->integer('available_seats');     // Kursi tersisa
            $table->string('status')->default('active'); // Status: active, cancelled, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};