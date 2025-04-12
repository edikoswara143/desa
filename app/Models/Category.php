<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\ValidationException;

class Category extends Model
{
  use SoftDeletes;
  protected $fillable = [
    'name',
    'slug',
    'thumbnail'
  ];

  // protected static function boot()
  // {
  //   parent::boot();

  //   static::creating(function ($slug) {
  //     dd($slug);
  //     if (\App\Models\Category::where('slug', $slug->slug)
  //       ->where('slug', $slug->slug)
  //       ->exists()
  //     ) {
  //       Notification::make()
  //         ->title('Error')
  //         ->body('This Slug is already assigned to another slug.')
  //         ->danger()
  //         ->send();

  //       throw ValidationException::withMessages([
  //         'slug' => 'This Slug is already assigned to another Slug.'
  //       ]);
  //     }
  //   });

  //   static::updating(function ($slug) {
  //     // dd($slug);
  //     if (\App\Models\Category::where('slug', $slug->slug)
  //       ->exists()
  //     ) {
  //       Notification::make()
  //         ->title('Error')
  //         ->body('This slug is already assigned to another slug.')
  //         ->danger()
  //         ->send();

  //       throw ValidationException::withMessages([
  //         'slug' => 'This slug is already assigned to another slug.'
  //       ]);
  //     }
  //   });
  // }

  public function post(): HasMany
  {
    return $this->hasMany(Post::class);
  }
}
