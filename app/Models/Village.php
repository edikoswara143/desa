<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Village extends Model
{
  public function district(): BelongsTo
  {
    return $this->belongsTo(District::class, 'district_code', 'code');
  }

  public function rw(): HasMany
  {
    return $this->hasMany(Rw::class, 'village_code', 'code');
  }
}
