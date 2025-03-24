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
use Illuminate\Support\Str;

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
              ->label('Select Province')
              ->searchable()
              ->preload()
              ->live()
              ->afterStateUpdated(function (Set $set) {
                $set('city_code', null);
                $set('district_code', null);
                $set('village_code', null);
                $set('code', '');
                $set('rw_number', '');
              })
              ->reactive()
              ->afterStateUpdated(fn(callable $set) => $set('city_code', null)) // Reset subcategory on change
              ->required(),
            Forms\Components\Select::make('city_code')
              ->reactive()
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
                $set('rw_number', '');
              })
              ->preload(),
            Forms\Components\Select::make('district_code')
              ->options(fn(Get $get): Collection => District::query()
                ->where('city_code', $get('city_code'))
                ->pluck('name', 'code'))
              ->label('Select District')
              ->afterStateUpdated(function (Set $set) {
                $set('village_code', null);
                $set('code', '');
                $set('rw_number', '');
              })
              ->searchable()
              ->live()
              ->required()
              ->preload()
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
                $set('code', ($state ?? '') . '.' . strtoupper(Str::random(7)))
              )
              ->live()
              ->afterStateUpdated(function (Set $set, $state) {
                $set('rw_number', '');
                $set('code', ($state ?? '') . '.' . strtoupper(Str::random(7)));
                $set('code', strlen($state) < 7 ? '' : $state  . strtoupper(Str::random(7)));
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
              ->unique(ignoreRecord: true)
              ->label('Rw Number')
              ->integer()
              ->maxLength(255),
          ])
          ->columns(3)
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('code')
          ->searchable(),
        Tables\Columns\TextColumn::make('village.name')
          ->sortable()
          ->searchable(),
        Tables\Columns\TextColumn::make('rw_number')
          ->sortable()
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
      ->defaultSort('created_at', 'desc')
      ->filters([
        //
      ])
      ->actions([
        // Tables\Actions\EditAction::make(),
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

  public static function getNavigationBadge(): ?string
  {
    return static::getModel()::count();
  }

  /**
   * Ignore 'rw_code' when updating an RW
   */
  public static function mutateFormDataBeforeSave(array $data): array
  {
    if (request()->routeIs('filament.admin.resources.rws.edit')) {
      unset($data['code']); // Remove 'rw_code' from update request
    }
    return $data;
  }

  public static function beforeSave($record, array $data)
  {
    if (Rw::where('rw_code', $data['rw_code'])->where('id', '!=', $record->id)->exists()) {
      throw new \Exception('RW Code already exists!');
    }
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListRws::route('/'),
      'create' => Pages\CreateRw::route('/create'),
      // 'edit' => Pages\EditRw::route('/{record}/edit'),
    ];
  }
}
