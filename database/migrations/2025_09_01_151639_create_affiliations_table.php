<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2025_09_01_000005_create_affiliations_table.php
return new class extends Migration {
    public function up() {
        Schema::create('affiliations', function (Blueprint $table) {
            $table->id('affiliation_id');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->unsignedBigInteger('entity_id');
            $table->string('entity_type'); // polymorphic: group/org
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('affiliations');
    }
};

