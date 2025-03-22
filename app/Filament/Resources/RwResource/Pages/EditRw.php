<?php

namespace App\Filament\Resources\RwResource\Pages;

use App\Filament\Resources\RwResource;
use App\Traits\RedirectIndex;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRw extends EditRecord
{
  protected static string $resource = RwResource::class;
  // protected function mutateFormDataBeforeSave(array $data): array
  // {
  //   return [
  //     'village_code' => $data['village_code'],
  //     'code' => $data['code'],
  //     'rw_number' => $data['rw_number'],
  //   ]; // Only saving these 3 fields
  // }
  use RedirectIndex;
  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
    ];
  }
}
