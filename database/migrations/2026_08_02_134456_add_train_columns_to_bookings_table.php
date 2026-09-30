<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('category')->nullable()->after('user_id');
            $table->string('nama_penumpang')->nullable();
            $table->string('nomor_ktp')->nullable();
            $table->string('email')->nullable();
            $table->string('no_telp')->nullable();
            $table->integer('jumlah_penumpang')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'nama_penumpang',
                'nomor_ktp',
                'email',
                'no_telp',
                'jumlah_penumpang',
            ]);
        });
    }
};