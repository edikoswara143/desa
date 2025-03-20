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
    Schema::create('rts', function (Blueprint $table) {
      $table->id();
      $table->string('code')->unique();
      $table->string('rw_code');
      $table->string('rt_number');
      $table->index('code');
      $table->foreign('rw_code')
        ->references('code')->on('rws')
        ->constrained('rws')
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
    Schema::dropIfExists('rts');
  }
};
