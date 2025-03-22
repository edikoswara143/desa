<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

class Rt extends Model
{
  protected $fillable = [
    'code',
    'village_code',
    'province_code',
    'city_code',
    'district_code',
    'rw_code',
    'rt_number',
  ];
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($rwRt) {
      // dd($rwRt->rw_code);
      if (\App\Models\Rt::where('rt_number', $rwRt->rt_number)
        ->where('rw_code', $rwRt->rw_code)
        ->exists()
      ) {
        Notification::make()
          ->title('Error')
          ->body('This RT is already assigned to another RW.')
          ->danger()
          ->send();

        throw ValidationException::withMessages([
          'rt_number' => 'This RT is already assigned to another RW.'
        ]);
      }
    });

    static::updating(function ($rwRt) {
      if (\App\Models\Rt::where('rt_number', $rwRt->rt_number)
        ->where('rw_code', $rwRt->rw_code)
        ->exists()
      ) {
        Notification::make()
          ->title('Error')
          ->body('This RT is already assigned to another RW.')
          ->danger()
          ->send();

        throw ValidationException::withMessages([
          'rt_number' => 'This RT is already assigned to another RW.'
        ]);
      }
    });
  }

  public function village(): BelongsTo
  {
    return $this->belongsTo(Village::class, 'village_code', 'code');
  }
  public function province(): BelongsTo
  {
    return $this->belongsTo(Province::class, 'province_code', 'code');
  }
  public function city(): BelongsTo
  {
    return $this->belongsTo(City::class, 'city_code', 'code');
  }
  public function rw(): BelongsTo
  {
    return $this->belongsTo(Rw::class, 'rw_code', 'code');
  }
}
