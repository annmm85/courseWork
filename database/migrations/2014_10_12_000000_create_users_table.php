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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('subscribes', function (Blueprint $table) {
            $table->primary(['user_id', 'author_id']);
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'subscribes_user_id'
            );
            $table->foreignId('author_id')->constrained(
                table: 'users', indexName: 'author_id'
            );
            $table->timestamps();
        });
        Schema::create('users_categories', function (Blueprint $table) {
            $table->primary(['user_id', 'category_id']);
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'categories_user_id'
            );
            $table->foreignId('category_id')->constrained(
                table: 'categories', indexName: 'category_id'
            );
            $table->timestamps();
        });
        Schema::create('usernotifies', function (Blueprint $table) {
            $table->primary(['user_id', 'notify_id']);
            $table->foreignId('user_id')->constrained(
                table: 'users', indexName: 'usernotifies_user_id'
            );
            $table->foreignId('notify_id')->constrained(
                table: 'notifies', indexName: 'notify_id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
