<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('flights', function (Blueprint $table) {
        $table->string('airline');
        $table->string('origin');
        $table->string('destination');
        $table->timestamp('departure_time');
        $table->timestamp('arrival_time');
        $table->decimal('price', 12, 2);
        $table->integer('capacity');
        $table->integer('available_seats');
        $table->string('status')->default('active');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flights', function (Blueprint $table) {
            //
        });
    }
};
