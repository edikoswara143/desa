<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum PostStatus: string implements HasLabel, HasColor
{
  case Yes = 'yes';
  case No = 'no';

  public function getLabel(): ?string
  {
    // return $this->name;
    return match ($this) {
      self::Yes => 'Yes',
      self::No => 'No',
    };
  }

  public function getColor(): string|array|null
  {
    return match ($this) {
      self::Yes => 'success',
      self::No => 'warning',
    };
  }
}
