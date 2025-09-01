<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('groups', function (Blueprint $table) {
            $table->id('group_id');
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->cascadeOnDelete();
            $table->string('name');
            $table->enum('type',['public','private']);
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('groups');
    }
};

