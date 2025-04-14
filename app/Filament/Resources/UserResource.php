<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserResource extends Resource
{
  protected static ?string $model = User::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
  protected static ?string $navigationGroup = 'Settings';
  protected static ?int $navigationSort = 1;
  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('name')
          ->required()
          ->maxLength(255),
        Forms\Components\TextInput::make('email')
          ->email()
          ->required()
          ->maxLength(255),
        Forms\Components\DateTimePicker::make('email_verified_at')
          ->closeOnDateSelection()
          ->visible(function () {
            $authUser = Auth::user();
            if (!$authUser) {
              return false;
            }
            $user = User::find($authUser->id);
            return $user->hasRole('admin');
          })
          ->maxDate(now()),
        Forms\Components\TextInput::make('password')
          ->password()
          ->dehydrateStateUsing(fn($state) => Hash::make($state))
          ->dehydrated(fn($state) => filled($state))
          // ->required()
          ->maxLength(255),
        Forms\Components\Select::make('roles')
          ->relationship('roles', 'name')
          ->columnSpanFull()
          ->visible(function () {
            $authUser = Auth::user();
            if (!$authUser) {
              return false;
            }
            $user = User::find($authUser->id);
            return $user->hasRole('admin');
          })
          ->native(true)
          ->preload(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('name')
          ->searchable(),
        Tables\Columns\TextColumn::make('email')
          ->searchable(),
        Tables\Columns\TextColumn::make('email_verified_at')
          ->dateTime()
          ->toggleable(isToggledHiddenByDefault: true)
          ->sortable(),
        Tables\Columns\TextColumn::make('roles')
          ->label('Role')
          // ->sortable()
          ->getStateUsing(fn($record) => collect($record->roles)
            ->pluck('name')
            ->map(fn($name) => Str::headline(str_replace('_', ' ', $name))))
          ->colors([
            'info',
          ])
          ->badge(),
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
        Tables\Filters\TrashedFilter::make(),
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\ViewAction::make(),
        Tables\Actions\DeleteAction::make(),
        Tables\Actions\ForceDeleteAction::make(),
        Tables\Actions\RestoreAction::make(),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
          Tables\Actions\ForceDeleteBulkAction::make(),
          Tables\Actions\RestoreBulkAction::make(),
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

  public static function getEloquentQuery(): Builder
  {
    $user = User::find(Auth::user()->id);
    // $user = auth()->user();

    if ($user->hasRole('admin')) {
      return parent::getEloquentQuery();
    }

    return parent::getEloquentQuery()->where('id', $user->id);
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListUsers::route('/'),
      'create' => Pages\CreateUser::route('/create'),
      'edit' => Pages\EditUser::route('/{record}/edit'),
    ];
  }
}
