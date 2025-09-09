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
        // migration
        Schema::create('organizations', function (Blueprint $table) {
        $table->id('organization_id');
        $table->foreignId('parent_organization_id')->nullable()->constrained('organizations','organization_id');
        $table->string('name');
        $table->string('address')->nullable();
        $table->string('contact')->nullable();
        $table->string('logo_url')->nullable();
        $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
