<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id('organization_id');
            $table->foreignId('parent_organization_id')->nullable()->constrained('organizations')->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('organizations');
    }
};

