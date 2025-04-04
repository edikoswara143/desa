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
    Schema::create('villages', function (Blueprint $table) {
      $table->id();
      $table->string('code')->unique();
      $table->string('district_code');
      $table->string('name');
      $table->index('code');
      $table->foreign('district_code')
        ->references('code')->on('districts')
        ->constrained('districts')
        ->cascadeOnDelete();
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('villages');
  }
};
