<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model

{
  use SoftDeletes;
  protected $fillable = [
    'user_id',
    'categories_id',
    'title',
    'slug',
    'content',
    'thumbnail',
    'publish'
  ];

  // protected $casts = [
  //   'publish' =>  PostStatus::class,
  // ];

  protected static function booted()
  {
    static::creating(function ($model) {
      $model->user_id = Auth::user()->id;
    });
  }

  public function categories(): BelongsTo
  {
    return $this->belongsTo(Category::class);
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
