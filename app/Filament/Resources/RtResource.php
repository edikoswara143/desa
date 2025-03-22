<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RtResource\Pages;
use App\Filament\Resources\RtResource\RelationManagers;
use App\Models\City;
use App\Models\District;
use App\Models\Rt;
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


class RtResource extends Resource
{
  protected static ?string $model = Rt::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
  protected static ?string $navigationGroup = 'Management Wilayah';
  protected static ?int $navigationSort = 6;
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
                $set('rw_code', '');
                $set('code', '');
                $set('rt_number', '');
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
                $set('rw_code', '');
                $set('code', '');
                $set('rt_number', '');
              })
              ->preload(),
            Forms\Components\Select::make('district_code')
              ->options(fn(Get $get): Collection => District::query()
                ->where('city_code', $get('city_code'))
                ->pluck('name', 'code'))
              ->label('Select District')
              ->afterStateUpdated(function (Set $set) {
                $set('village_code', null);
                $set('rw_code', '');
                $set('code', '');
                $set('rt_number', '');
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
              ->live()
              ->afterStateUpdated(function (Set $set, $state) {
                $set('rw_code', '');
                $set('code', '');
                $set('rt_number', '');
              })
              ->required()
              ->preload(),
            // Forms\Components\TextInput::make('code')
            //   ->required()
            //   ->readOnly()
            //   ->live()
            //   ->label('Kode Rw')
            //   ->maxLength(255),
            Forms\Components\Select::make('rw_code')
              ->reactive()
              ->options(fn(Get $get): Collection => Rw::query()
                ->where('village_code', $get('village_code'))
                ->pluck('rw_number', 'code'))
              ->label('Select Rw number')
              ->searchable()
              ->live()
              ->required()
              ->afterStateUpdated(
                fn($state, callable $set, callable $get) =>
                $set('code', ($state ?? '') . '.' . strtoupper(Str::random(10)))
              )
              ->afterStateUpdated(function (Set $set, $state) {
                $set('rt_number', '');
                $set('code', ($state ?? '') . '.' . strtoupper(Str::random(10)));
                $set('code', strlen($state) < 10 ? '' : $state  . strtoupper(Str::random(10)));
              })
              ->preload(),
            Forms\Components\TextInput::make('code')
              ->required()
              ->readOnly()
              ->live()
              ->label('Kode Rt')
              ->maxLength(255),
            Forms\Components\TextInput::make('rt_number')
              ->required()
              // ->unique(ignoreRecord: true)
              // ->rule('unique:rw_code,rt_code')
              // ->rule('unique:rw,rt_number')
              ->label('RT Number')
              ->validationMessages([
                'unique' => 'This RT is already assigned to another RW.',
              ])
              ->integer()
              ->maxLength(255),
          ])
          ->columns(4)
        // Forms\Components\TextInput::make('code')
        //   ->required()
        //   ->maxLength(255),
        // Forms\Components\TextInput::make('rw_code')
        //   ->required()
        //   ->maxLength(255),
        // Forms\Components\TextInput::make('rt_number')
        //   ->required()
        //   ->maxLength(255),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('code')
          ->searchable(),
        Tables\Columns\TextColumn::make('rw.rw_number')
          ->sortable()
          ->searchable(),
        Tables\Columns\TextColumn::make('rt_number')
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
      'index' => Pages\ListRts::route('/'),
      'create' => Pages\CreateRt::route('/create'),
      'edit' => Pages\EditRt::route('/{record}/edit'),
    ];
  }
}
