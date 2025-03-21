<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
  public function province(): BelongsTo
  {
    return $this->belongsTo(Province::class, 'province_code', 'code');
  }

  public function district(): HasMany
  {
    return $this->hasMany(District::class, 'city_code', 'code')->chaperone();
  }
  public function rw(): HasMany
  {
    return $this->hasMany(Rw::class, 'city_code', 'code')->chaperone();
  }
  public function resident(): HasMany
  {
    return $this->hasMany(Resident::class, 'city_code', 'code')->chaperone();
  }
}
