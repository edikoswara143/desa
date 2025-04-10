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
    Schema::create('districts', function (Blueprint $table) {
      $table->id();
      $table->string('code')->unique();
      $table->string('city_code');
      $table->string('name');
      $table->index('code');
      $table->foreign('city_code')
        ->references('code')->on('cities')
        ->constrained('cities')
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
    Schema::dropIfExists('districts');
  }
};
