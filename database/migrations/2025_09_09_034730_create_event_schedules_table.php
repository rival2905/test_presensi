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
        Schema::create('event_schedules', function (Blueprint $table) {
    $table->id('schedule_id');
    $table->foreignId('event_id')->constrained('events','event_id')->cascadeOnDelete();
    $table->dateTime('start_time');
    $table->dateTime('end_time')->nullable();
    $table->decimal('price',12,2)->default(0);
    $table->integer('quota')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_schedules');
    }
};
