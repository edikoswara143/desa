<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Rw extends Model
{

  protected $fillable = [
    'code',
    'village_code',
    'province_code',
    'city_code',
    'district_code',
    'rw_number',
  ];

  public function village(): BelongsTo
  {
    return $this->belongsTo(Village::class, 'village_code', 'code');
  }
  public function province(): BelongsTo
  {
    return $this->belongsTo(Province::class, 'province_code', 'code');
  }
}
