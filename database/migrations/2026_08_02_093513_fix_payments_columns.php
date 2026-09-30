<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Kita buang 'after()' supaya tidak bergantung pada kolom lain!
            // Dia akan otomatis menambah di urutan paling belakang tabel
            $table->string('status')->default('pending');
            $table->string('method')->nullable();
            $table->string('proof_image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['status', 'method', 'proof_image']);
        });
    }
};