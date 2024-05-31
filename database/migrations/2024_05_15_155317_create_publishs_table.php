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
            $table->string('image');
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'user_id'
            );
            $table->timestamps();
        });
        Schema::create('publishs_categories', function (Blueprint $table) {
            $table->primary(['publish_id', 'category_id']);
            $table->foreignId('publish_id')->constrained(
                table: 'publishs', indexName: 'categories_publish_id'
            );
            $table->foreignId('category_id')->constrained(
                table: 'categories', indexName: 'publishs_category_id'
            );
            $table->timestamps();
        });
        Schema::create('publishs_boxes', function (Blueprint $table) {
            $table->primary(['publish_id', 'box_id']);
            $table->foreignId('publish_id')->constrained(
                table: 'publishs', indexName: 'boxes_publish_id'
            );
            $table->foreignId('box_id')->constrained(
                table: 'boxes', indexName: 'box_id'
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
