<?php

namespace App\Filament\Resources\ResidentResource\Pages;

use App\Filament\Resources\ResidentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResidents extends ListRecords
{
  protected static string $resource = ResidentResource::class;
  protected function getFooterWidgets(): array
  {
    return [
      ResidentResource\Widgets\ResidentOverview::class,
    ];
  }

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make(),
    ];
  }
}
