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
    Schema::create('posts', function (Blueprint $table) {
      $table->id();
      $table->string('title')->unique();
      $table->string('slug')->unique();
      $table->text('content');
      $table->text('thumbnail');
      $table->string('publish');
      $table->softDeletes();
      $table->timestamps();
      $table->foreignId('user_id')->constrained()->cascadeOnDelete();
      $table->foreignId('categories_id')
        ->constrained()
        ->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('posts');
  }
};
