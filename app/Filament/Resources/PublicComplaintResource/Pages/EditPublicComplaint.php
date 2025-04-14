<?php

namespace App\Filament\Resources\PublicComplaintResource\Pages;

use App\Filament\Resources\PublicComplaintResource;
use App\Traits\RedirectIndex;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublicComplaint extends EditRecord
{
  use RedirectIndex;
  protected static string $resource = PublicComplaintResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\DeleteAction::make(),
      Actions\ForceDeleteAction::make(),
      Actions\RestoreAction::make(),
    ];
  }

  protected function getActions(): array
  {
    return [
      Actions\DeleteAction::make(),
      Actions\ForceDeleteAction::make(),
      Actions\RestoreAction::make(),
    ];
  }
}
