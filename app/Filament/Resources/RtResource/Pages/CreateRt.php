<?php

namespace App\Filament\Resources\RtResource\Pages;

use App\Filament\Resources\RtResource;
use App\Traits\RedirectIndex;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRt extends CreateRecord
{
  protected static string $resource = RtResource::class;
  use RedirectIndex;
}
