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
        Schema::create('attendance_records', function (Blueprint $table) {
    $table->id('record_id');
    $table->foreignId('activity_id')->constrained('activities','activity_id')->cascadeOnDelete();
    $table->foreignId('user_id')->constrained('users','user_id')->cascadeOnDelete();
    $table->string('photo_url')->nullable();
    $table->decimal('latitude',10,7)->nullable();
    $table->decimal('longitude',10,7)->nullable();
    $table->enum('status',['masuk','izin','sakit']);
    $table->string('reason')->nullable();
    $table->string('attachment_url')->nullable();
    $table->timestamp('timestamp')->useCurrent();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
