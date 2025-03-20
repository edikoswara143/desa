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
    Schema::create('cities', function (Blueprint $table) {
      $table->id();
      $table->string('code')->unique();
      $table->string('province_code');
      $table->string('name');
      $table->softDeletes();
      $table->timestamps();
      $table->foreign('province_code')
        ->references('code')->on('provinces')
        ->constrained('provinces')
        ->cascadeOnDelete();
      $table->index('code');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cities');
  }
};
