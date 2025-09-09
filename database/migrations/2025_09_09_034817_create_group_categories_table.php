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
        Schema::create('group_categories', function (Blueprint $table) {
    $table->foreignId('group_id')->constrained('groups','group_id')->cascadeOnDelete();
    $table->foreignId('subcategory_id')->constrained('sub_categories','subcategory_id')->cascadeOnDelete();
    $table->primary(['group_id','subcategory_id']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_categories');
    }
};
