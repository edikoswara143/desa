<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resident extends Model
{
  protected $fillable = [
    'nik',
    'nkk',
    'name',
    'email',
    'birth_date',
    'sex',
    'address',
    'birth_date',
    'religion',
    'marital_status',
    'occupation',
    'religion',
    'nationality',
    'blood_type',
    'picture',
    'village_code',
    'province_code',
    'city_code',
    'district_code',
    'rw_code',
    'rt_code',
  ];
  public function province(): BelongsTo
  {
    return $this->belongsTo(Province::class, 'province_code', 'code');
  }
  public function city(): BelongsTo
  {
    return $this->belongsTo(City::class, 'city_code', 'code');
  }
  public function district(): BelongsTo
  {
    return $this->belongsTo(District::class, 'district_code', 'code');
  }
  public function village(): BelongsTo
  {
    return $this->belongsTo(Village::class, 'village_code', 'code');
  }
  public function rw(): BelongsTo
  {
    return $this->belongsTo(Rw::class, 'rw_code', 'code');
  }
  public function rt(): BelongsTo
  {
    return $this->belongsTo(Rt::class, 'rt_code', 'code');
  }
}
