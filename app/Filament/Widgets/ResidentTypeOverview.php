<?php

namespace App\Filament\Widgets;

use App\Models\Resident;
use App\Models\Rt;
use App\Models\Rw;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ResidentTypeOverview extends BaseWidget
{
  protected function getStats(): array
  {
    return [
      Stat::make('Resident', Resident::count()),
      Stat::make('RT', Rt::count()),
      Stat::make('RW', Rw::count()),
    ];
  }
}
