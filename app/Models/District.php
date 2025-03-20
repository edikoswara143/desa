<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
  public function city(): BelongsTo
  {
    return $this->belongsTo(City::class, 'city_code', 'code');
  }

  public function village(): HasMany
  {
    return $this->hasMany(Village::class, 'village_code', 'code');
  }
}
