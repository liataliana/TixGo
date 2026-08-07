<?php
// [Magfi Adi Radza Putra] - Migration Create Transactions Table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('invoice_number', 50)->unique();
            $table->integer('total_amount');
            $table->string('status', 20)->default('pending');
            $table->string('payment_method', 50)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
        
        DB::statement("ALTER TABLE transactions ADD CONSTRAINT chk_transaction_status CHECK (status IN ('pending','paid','cancelled'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
