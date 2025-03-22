<?php

namespace App\Filament\Resources\ResidentResource\Pages;

use App\Filament\Resources\ResidentResource;
use App\Traits\RedirectIndex;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateResident extends CreateRecord
{
  protected static string $resource = ResidentResource::class;
  use RedirectIndex;
}
