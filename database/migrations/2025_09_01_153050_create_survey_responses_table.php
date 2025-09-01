<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id('response_id');
            $table->foreignId('survey_id')->constrained('surveys')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('response_text');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('survey_responses');
    }
};

