<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id('registration_id');
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('registration_date')->useCurrent();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('event_registrations');
    }
};
