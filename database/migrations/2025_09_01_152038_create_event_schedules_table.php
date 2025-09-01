<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('event_schedules', function (Blueprint $table) {
            $table->id('schedule_id');
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('location');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('event_schedules');
    }
};

