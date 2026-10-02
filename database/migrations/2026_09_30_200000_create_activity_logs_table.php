<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('role', 50)->default('manager'); // who did it
            $table->string('action', 100); // e.g. 'confirm_payment', 'add_flight'
            $table->text('description')->nullable(); // human-readable detail
            $table->string('target_type', 100)->nullable(); // e.g. 'Payment', 'Flight'
            $table->unsignedBigInteger('target_id')->nullable(); // ID of affected record
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
