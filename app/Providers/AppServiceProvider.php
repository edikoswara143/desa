<?php

namespace App\Providers;

use App\Http\Responses\LoginResponse as LoginResponseContract;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->bind(LoginResponseContract::class, LoginResponse::class);
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Filament::serving(function () {
      Filament::registerNavigationGroups([
        NavigationGroup::make()
          ->label('Settings'),
        NavigationGroup::make()
          ->label('Resident'),
        // ->icon('heroicon-s-user'),
        NavigationGroup::make()
          ->label('Management Wilayah')
        // ->icon('heroicon-o-rectangle-stack'),
      ]);
    });
  }
}
