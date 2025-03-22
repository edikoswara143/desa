<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
  public function city(): HasMany
  {
    return $this->hasMany(City::class, 'province_code', 'code')->chaperone();
  }
  public function rw(): HasMany
  {
    return $this->hasMany(Rw::class, 'province_code', 'code')->chaperone();
  }
  public function rt(): HasMany
  {
    return $this->hasMany(Rt::class, 'province_code', 'code')->chaperone();
  }
  public function resident(): HasMany
  {
    return $this->hasMany(Resident::class, 'province_code', 'code')->chaperone();
  }
}
