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
        Schema::create('affiliations', function (Blueprint $table) {
    $table->id('affiliation_id');
    $table->foreignId('user_id')->constrained('users','user_id');
    $table->foreignId('role_id')->constrained('roles','role_id');
    $table->unsignedBigInteger('entity_id');
    $table->enum('entity_type',['organization','group']);
    $table->enum('status',['active','inactive','pending']);
    $table->timestamp('joined_at')->nullable();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliations');
    }
};
