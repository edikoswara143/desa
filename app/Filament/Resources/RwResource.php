<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RwResource\Pages;
use App\Filament\Resources\RwResource\RelationManagers;
use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\Rw;
use App\Models\Village;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class RwResource extends Resource
{
  protected static ?string $model = Rw::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
  protected static ?string $navigationGroup = 'Management Wilayah';
  protected static ?int $navigationSort = 5;
  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Fieldset::make('Wilayah')
          ->schema([
            Forms\Components\Select::make('province_code')
              ->relationship(name: 'province', titleAttribute: 'name')
              // ->options(Province::all()->pluck('name', 'kode'))
              ->label('Select Province')
              ->searchable()
              ->preload()
              ->live()
              ->afterStateUpdated(function (Set $set) {
                $set('city_code', null);
                $set('district_code', null);
                $set('village_code', null);
                $set('code', '');
                $set('name', '');
              })
              // ->afterStateUpdated(
              //   fn($state, callable $set, callable $get) =>
              //   $set('code', ($state ?? '') . '.' . ($get('city_code') ?? ''))
              // )
              // ->afterStateUpdated(function (Get $get, Set $set) {
              //   $set('code', fn(Get $get): Collection => Province::query()
              //     ->where('kode', $get('province_kode'))
              //     ->pluck('kode'));
              // })
              ->required(),
            Forms\Components\Select::make('city_code')
              ->options(fn(Get $get): Collection => City::query()
                ->where('province_code', $get('province_code'))
                ->pluck('name', 'code'))
              ->label('Select City')
              ->searchable()
              ->live()
              ->required()
              ->afterStateUpdated(function (Set $set) {
                $set('district_code', null);
                $set('village_code', null);
                $set('code', '');
                $set('name', '');
              })
              // ->afterStateUpdated(
              //   fn($state, callable $set, callable $get) =>
              //   $set('code', ($get('province_code') ?? '') . '.' . ($state ?? ''))
              // )
              // ->afterStateUpdated(function (Get $get, Set $set) {
              //   $set('kode', fn(Get $get): Collection => City::query()
              //     ->where('province_kode', $get('province_kode'))
              //     ->where('kode', $get('city_kode'))
              //     ->pluck('kode'));
              // })
              ->preload(),
            Forms\Components\Select::make('district_code')
              ->options(fn(Get $get): Collection => District::query()
                ->where('city_code', $get('city_code'))
                ->pluck('name', 'code'))
              ->label('Select District')
              ->afterStateUpdated(function (Set $set) {
                $set('village_code', null);
                $set('code', '');
                $set('name', '');
              })
              // ->afterStateUpdated(fn(Set $set) => $set('village_code', null))
              // ->afterStateUpdated(
              //   fn($state, callable $set, callable $get) =>
              //   $set('code', ($get('city_code') ?? '') . '.' . ($state ?? ''))
              // )
              ->searchable()
              ->live()
              ->required()
              ->preload()
            // ->afterStateUpdated(fn(Set $set) => $set('city_kode', null))
          ])
          ->columns(3),
        Fieldset::make('Wilayah')
          ->schema([
            Forms\Components\Select::make('village_code')
              ->options(fn(Get $get): Collection => Village::query()
                ->where('district_code', $get('district_code'))
                ->pluck('name', 'code'))
              ->label('Select Village')
              ->searchable()
              ->afterStateUpdated(
                fn($state, callable $set, callable $get) =>
                $set('code', ($state ?? '') . '.' . (substr(preg_replace('/\D/', '', $state), -4)))
              )
              ->live()
              ->afterStateUpdated(function (Set $set, $state) {
                // $set('village_code', null);
                // $set('code', '');
                $set('name', '');
                $set('code', strlen($state) < 4 ? '' : $state  . '.' . (substr(preg_replace('/\D/', '', $state), -4)) ?? '');
              })
              ->required()
              ->preload(),
            Forms\Components\TextInput::make('code')
              ->required()
              ->readOnly()
              ->live()
              ->label('Kode Rw')
              ->maxLength(255),
            Forms\Components\TextInput::make('rw_number')
              ->required()
              ->label('Rw Number')
              ->integer()
              ->maxLength(255),
          ])
          ->columns(3)
      ]);
    // ->schema([
    //   Forms\Components\TextInput::make('code')
    //     ->required()
    //     ->maxLength(255),
    //   Forms\Components\Select::make('village_code')
    //     ->relationship(name: 'village', titleAttribute: 'name')
    //     // ->options(Province::all()->pluck('name', 'kode'))
    //     ->label('Select Village')
    //     ->searchable()
    //     ->preload()
    //     ->live()
    //     ->optionsLimit(20)
    //     ->searchDebounce(500)
    //     ->required(),
    //   Forms\Components\TextInput::make('rw_number')
    //     ->required()
    //     ->maxLength(255),
    // ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('code')
          ->searchable(),
        Tables\Columns\TextColumn::make('village.name')
          ->searchable(),
        Tables\Columns\TextColumn::make('rw_number')
          ->searchable(),
        Tables\Columns\TextColumn::make('deleted_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('created_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('updated_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListRws::route('/'),
      'create' => Pages\CreateRw::route('/create'),
      'edit' => Pages\EditRw::route('/{record}/edit'),
    ];
  }
}
