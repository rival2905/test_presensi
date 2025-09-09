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
        Schema::create('parent_child_relationships', function (Blueprint $table) {
    $table->foreignId('parent_user_id')->constrained('users','user_id')->cascadeOnDelete();
    $table->foreignId('child_user_id')->constrained('users','user_id')->cascadeOnDelete();
    $table->enum('relationship_type',['ayah','ibu','wali','lainnya']);
    $table->primary(['parent_user_id','child_user_id']); // composite PK
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_child_relationships');
    }
};
