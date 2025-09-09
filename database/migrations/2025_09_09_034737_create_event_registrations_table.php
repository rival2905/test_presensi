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
        Schema::create('event_registrations', function (Blueprint $table) {
    $table->id('registration_id');
    $table->foreignId('user_id')->constrained('users','user_id')->cascadeOnDelete();
    $table->foreignId('schedule_id')->constrained('event_schedules','schedule_id')->cascadeOnDelete();
    $table->enum('status',['pending','approved','rejected']);
    $table->string('team_name')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
