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
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('schedule_id');
    $table->enum('status', ['pending', 'approved', 'rejected']);
    $table->string('team_name')->nullable();
    $table->timestamps();

    // Foreign keys
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('schedule_id')->references('schedule_id')->on('event_schedules')->onDelete('cascade');
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
