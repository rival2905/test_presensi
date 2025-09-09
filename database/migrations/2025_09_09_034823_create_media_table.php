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
        Schema::create('media', function (Blueprint $table) {
    $table->id('media_id');
    $table->foreignId('user_id')->nullable()->constrained('users','user_id')->cascadeOnDelete();
    $table->foreignId('group_id')->nullable()->constrained('groups','group_id')->cascadeOnDelete();
    $table->string('file_url');
    $table->enum('type',['image','video','document']);
    $table->text('description')->nullable();
    $table->timestamp('uploaded_at')->useCurrent();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
