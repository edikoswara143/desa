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
    Schema::table('rws', function (Blueprint $table) {
      $table->string('province_code');
      $table->string('city_code');
      $table->string('district_code');
      $table->foreign('province_code')
        ->references('code')->on('provinces')
        ->constrained('provinces')
        ->cascadeOnDelete();
      $table->foreign('city_code')
        ->references('code')->on('cities')
        ->constrained('cities')
        ->cascadeOnDelete();
      $table->foreign('district')
        ->references('code')->on('districts')
        ->constrained('districts')
        ->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('rws', function (Blueprint $table) {
      //
    });
  }
};
