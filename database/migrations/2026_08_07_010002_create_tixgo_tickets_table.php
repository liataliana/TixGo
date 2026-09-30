<?php
// [Magfi Adi Radza Putra] - Migration Create TixGo Tickets Table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tixgo_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('ticket_code', 20)->unique();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->integer('price');
            $table->integer('stock')->default(0);
            $table->string('location', 200)->nullable();
            $table->date('event_date')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        DB::statement('ALTER TABLE tixgo_tickets ADD CONSTRAINT chk_ticket_price_positive CHECK (price > 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('tixgo_tickets');
    }
};
