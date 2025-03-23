<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResidentResource\Pages;
use App\Filament\Resources\ResidentResource\RelationManagers;
use App\Models\City;
use App\Models\District;
use App\Models\Resident;
use App\Models\Rt;
use App\Models\Rw;
use App\Models\Village;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Collection;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ResidentResource extends Resource
{
  protected static ?string $model = Resident::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
  protected static ?string $navigationGroup = 'Resident';
  protected static ?int $navigationSort = 1;

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
                $set('rt_code', '');
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
                $set('rt_code', '');
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
                $set('rt_code', '');
              })
              ->searchable()
              ->live()
              ->required()
              ->preload(),
            Forms\Components\Select::make('village_code')
              ->options(fn(Get $get): Collection => Village::query()
                ->where('district_code', $get('district_code'))
                ->pluck('name', 'code'))
              ->label('Select Village')
              ->searchable()
              ->live()
              ->afterStateUpdated(function (Set $set, $state) {
                $set('rw_code', '');
                $set('rt_number', '');
              })
              ->required()
              ->preload(),
            Forms\Components\Select::make('rw_code')
              ->reactive()
              ->options(fn(Get $get): Collection => Rw::query()
                ->where('village_code', $get('village_code'))
                ->pluck('rw_number', 'code'))
              ->label('Select Rw number')
              ->searchable()
              ->live()
              ->required()
              // ->afterStateUpdated(
              //   // fn($state, callable $set, callable $get) =>
              //   // $set('code', ($state ?? '') . '.' . strtoupper(Str::random(10)))
              // )
              ->afterStateUpdated(function (Set $set, $state) {
                $set('rt_code', '');
                // $set('code', ($state ?? '') . '.' . strtoupper(Str::random(10)));
                // $set('code', strlen($state) < 10 ? '' : $state  . strtoupper(Str::random(10)));
              })
              ->preload(),
            Forms\Components\Select::make('rt_code')
              ->reactive()
              ->options(fn(Get $get): Collection => Rt::query()
                ->where('rw_code', $get('rw_code'))
                ->pluck('rt_number', 'code'))
              ->label('Select Rt number')
              ->searchable()
              ->live()
              ->required()
              // ->afterStateUpdated(
              //   // fn($state, callable $set, callable $get) =>
              //   // $set('code', ($state ?? '') . '.' . strtoupper(Str::random(10)))
              // )
              // ->afterStateUpdated(function (Set $set, $state) {
              //   $set('rt_code', '');
              //   // $set('code', ($state ?? '') . '.' . strtoupper(Str::random(10)));
              //   // $set('code', strlen($state) < 10 ? '' : $state  . strtoupper(Str::random(10)));
              // })
              ->preload(),
          ])
          ->columns(3),
        Fieldset::make('Resident Data')
          ->schema([
            Forms\Components\TextInput::make('nik')
              ->required()
              ->validationMessages([
                'unique' => 'This NIK is already assigned to another NIK.',
              ])
              ->integer()
              ->maxLength(16),
            Forms\Components\TextInput::make('nkk')

              ->required()
              ->integer()
              ->maxLength(16),
            Forms\Components\TextInput::make('name')
              ->required()
              ->maxLength(255),
            Forms\Components\TextInput::make('email')
              ->email()
              ->required()
              ->email()
              ->maxLength(255),
            DatePicker::make('birth_date')
              ->native(false)
              ->required(),
            Select::make('sex')
              ->searchable()
              ->options([
                'male' => 'male',
                'female' => 'female',
              ]),
            Textarea::make('address')
              ->required(),
            Select::make('religion')
              ->searchable()
              ->options([
                'islam' => 'Islam',
                'kriten' => 'Kristen',
              ]),
            Select::make('marital_status')
              ->searchable()
              ->options([
                'meried' => 'Meried',
                'jomblo' => 'Jomblo',
              ]),
            Select::make('occupation')
              ->searchable()
              ->options([
                'work' => 'Work',
                'other' => 'other',
              ]),
            Forms\Components\TextInput::make('nationality')
              ->required()
              ->maxLength(255),
            Select::make('blood_type')
              ->searchable()
              ->options([
                'o' => 'O',
                'a' => 'A',
                'b' => 'B',
                'ab' => 'AB',
              ]),
          ])
          ->columns(3),
        Fieldset::make('picture')
          ->schema([
            FileUpload::make('picture')
              // ->disk('s3')
              // ->directory('form-attachments')
              ->columnSpanFull()
              ->image()
              ->visibility('public')
              ->required()
              // ->disk('public')  // Ensure the correct disk is used
              // ->directory('picture') // Store images in "storage/app/public/uploads"
              // ->visibility('public') // Ensure the file is accessible
              ->maxSize(1024)
              ->getUploadedFileNameForStorageUsing(
                fn(TemporaryUploadedFile $file): string => (string) str($file->getClientOriginalName())
                  ->prepend('picture-' . now()->timestamp),
              )
          ])
          ->columnSpanFull()
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\ImageColumn::make('picture')
          ->searchable(),
        Tables\Columns\TextColumn::make('nkk')
          ->label('NKK')
          ->searchable(),
        Tables\Columns\TextColumn::make('nik')
          ->label('NIK')
          ->searchable(),
        Tables\Columns\TextColumn::make('name')
          ->searchable(),
        Tables\Columns\TextColumn::make('email')
          ->toggleable()
          ->searchable(),
        Tables\Columns\TextColumn::make('birth_date')
          ->searchable()
          ->toggleable(),
        Tables\Columns\TextColumn::make('sex')
          ->toggleable()
          ->searchable(),
        Tables\Columns\TextColumn::make('address')
          ->toggleable()
          ->searchable(),
        Tables\Columns\TextColumn::make('religion')
          ->toggleable()
          ->searchable(),
        Tables\Columns\TextColumn::make('marital_status')
          ->toggleable()
          ->searchable(),
        Tables\Columns\TextColumn::make('occupation')
          ->toggleable()
          ->searchable(),
        Tables\Columns\TextColumn::make('nationality')
          ->toggleable()
          ->searchable(),
        Tables\Columns\TextColumn::make('blood_type')
          ->toggleable()
          ->searchable(),
        Tables\Columns\TextColumn::make('province.name')
          ->toggleable()
          ->searchable(),
        Tables\Columns\TextColumn::make('city.name')
          ->toggleable()
          ->searchable(),
        Tables\Columns\TextColumn::make('district.name')
          ->toggleable()
          ->searchable(),
        Tables\Columns\TextColumn::make('village.name')
          ->toggleable()
          ->searchable(),
        Tables\Columns\TextColumn::make('rw.rw_number')
          ->searchable(),
        Tables\Columns\TextColumn::make('rt.rt_number')
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
        Tables\Actions\ViewAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ]);
  }

  public static function getGloballySearchableAttributes(): array
  {
    return ['nik', 'nkk', 'name'];
  }
  public static function getNavigationBadge(): ?string
  {
    return static::getModel()::count();
  }
  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  protected function getFooterWidgetsColumns(): int | array
  {
    return 1;
  }
  public static function getWidgets(): array
  {
    return [
      ResidentResource\Widgets\ResidentOverview::class,
    ];
  }
  protected int | string | array $columnSpan = 'full';

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListResidents::route('/'),
      'create' => Pages\CreateResident::route('/create'),
      'view' => Pages\ViewResident::route('/{record}'),
      'edit' => Pages\EditResident::route('/{record}/edit'),
    ];
  }
}
