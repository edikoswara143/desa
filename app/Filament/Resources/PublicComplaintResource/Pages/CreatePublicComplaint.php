<?php

namespace App\Filament\Resources\PublicComplaintResource\Pages;

use App\Filament\Resources\PublicComplaintResource;
use App\Traits\RedirectIndex;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePublicComplaint extends CreateRecord
{
  use RedirectIndex;
  protected static string $resource = PublicComplaintResource::class;
  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['user_id'] = Auth::user()->id;
    return $data;
  }
}
