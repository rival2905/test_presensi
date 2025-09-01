<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('likes', function (Blueprint $table) {
            $table->id('like_id');
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('timestamp')->useCurrent();
        });
    }
    public function down() {
        Schema::dropIfExists('likes');
    }
};

