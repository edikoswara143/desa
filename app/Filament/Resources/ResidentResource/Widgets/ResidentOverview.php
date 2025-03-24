<?php

namespace App\Filament\Resources\ResidentResource\Widgets;

use App\Models\Resident;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ResidentOverview extends ChartWidget
{
  protected static ?string $heading = 'Chart';
  protected int | string | array $columnSpan = 'full';

  protected function getData(): array
  {

    $data = Trend::model(Resident::class)
      ->between(
        start: now()->startOfYear(),
        end: now()->endOfYear(),
      )
      ->perMonth()
      ->count();

    return [
      'datasets' => [
        [
          'label' => 'Resident',
          'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
        ],
      ],
      'labels' => $data->map(fn(TrendValue $value) => $value->date),
    ];
    // return [
    //   'datasets' => [
    //     [
    //       'label' => 'Resident',
    //       'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
    //     ],
    //   ],
    //   'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    // ];
  }

  protected function getType(): string
  {
    return 'line';
  }
}
