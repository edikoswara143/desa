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
    Schema::create('residents', function (Blueprint $table) {
      $table->id();
      $table->string('nik')->unique();
      $table->string('nkk');
      $table->string('name');
      $table->string('email');
      $table->string('birth_date');
      $table->string('sex');
      $table->string('address');
      $table->string('religion');
      $table->string('marital_status');
      $table->string('occupation');
      $table->string('nationality');
      $table->string('blood_type');
      $table->string('province_code');
      $table->string('city_code');
      $table->string('district_code');
      $table->string('village_code');
      $table->string('rw_code');
      $table->string('rt_code');
      $table->index('nik');
      $table->foreign('province_code')
        ->references('code')->on('provinces')
        ->constrained('provinces')
        ->cascadeOnDelete();
      $table->foreign('city_code')
        ->references('code')->on('cities')
        ->constrained('cities')
        ->cascadeOnDelete();
      $table->foreign('district_code')
        ->references('code')->on('districts')
        ->constrained('districts')
        ->cascadeOnDelete();
      $table->foreign('village_code')
        ->references('code')->on('villages')
        ->constrained('districts')
        ->cascadeOnDelete();
      $table->foreign('rw_code')
        ->references('code')->on('rws')
        ->constrained('rws')
        ->cascadeOnDelete();
      $table->foreign('rt_code')
        ->references('code')->on('rts')
        ->constrained('rts')
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
    Schema::dropIfExists('residents');
  }
};
