<?php

namespace App\Filament\Resources\RtResource\Pages;

use App\Filament\Resources\RtResource;
use App\Traits\RedirectIndex;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRt extends EditRecord
{
  protected static string $resource = RtResource::class;
  use RedirectIndex;
  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }
}
