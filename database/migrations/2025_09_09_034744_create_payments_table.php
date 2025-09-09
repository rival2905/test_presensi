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
        // migration
Schema::create('payments', function (Blueprint $table) {
    $table->id('payment_id');
    $table->foreignId('registration_id')->constrained('event_registrations','registration_id')->cascadeOnDelete();
    $table->decimal('amount',12,2);
    $table->enum('payment_method',['cash','transfer','ewallet']);
    $table->enum('status',['pending','paid','failed']);
    $table->timestamp('paid_at')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
