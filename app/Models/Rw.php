<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rw extends Model
{
  public function village(): BelongsTo
  {
    return $this->belongsTo(Village::class, 'village_code', 'code');
  }
  public function province(): BelongsTo
  {
    return $this->belongsTo(Province::class, 'province_code', 'code');
  }
}
