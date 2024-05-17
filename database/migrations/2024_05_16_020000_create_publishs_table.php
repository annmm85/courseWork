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
        Schema::create('publishs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('desc');
            $table->foreignId('category_id')->constrained(
                table: 'categories', indexName: 'category_id'
            );
            $table->string('image');
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'user_id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishs');
    }
};
