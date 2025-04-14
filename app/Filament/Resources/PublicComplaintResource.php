<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicComplaintResource\Pages;
use App\Filament\Resources\PublicComplaintResource\RelationManagers;
use App\Models\PublicComplaint;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PublicComplaintResource extends Resource
{
  protected static ?string $model = PublicComplaint::class;
  protected static bool $shouldRegisterNavigation = true;
  protected static ?string $policy = \App\Policies\PublicComplaintPolicy::class;
  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
  protected static ?string $navigationGroup = 'Public Service';
  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('subject')
          ->required()
          ->columnSpanFull()
          ->maxLength(255),
        Forms\Components\RichEditor::make('description')
          ->required()
          ->columnSpanFull(),
        Select::make('status')
          ->options([
            'pending' => 'Pending',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
          ])
          ->visible(function () {
            $authUser = Auth::user();
            if (!$authUser) {
              return false;
            }
            $user = User::find($authUser->id);
            return $user->hasRole('admin');
          })
          ->required()
          ->columnSpanFull(),
        Forms\Components\FileUpload::make('image')
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
              ->prepend('publiccomplaint-image-' . now()->timestamp),
          )
          ->required(),
        Forms\Components\Hidden::make('user_id')
        // ->numeric(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('subject')
          ->searchable(),
        Tables\Columns\TextColumn::make('status')
          ->searchable()
          ->badge()
          ->color(fn(string $state): string => match ($state) {
            'pending' => 'warning',
            'accepted' => 'success',
            'rejected' => 'danger',
          }),
        Tables\Columns\ImageColumn::make('image'),
        Tables\Columns\TextColumn::make('user.name')
          ->numeric()
          ->sortable(),
        Tables\Columns\TextColumn::make('created_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('updated_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('deleted_at')
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

  public static function getEloquentQuery(): Builder
  {
    $user = User::find(Auth::user()->id);
    // $user = auth()->user();

    if ($user->hasRole('admin')) {
      return parent::getEloquentQuery();
    }

    return parent::getEloquentQuery()->where('user_id', $user->id);
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListPublicComplaints::route('/'),
      'create' => Pages\CreatePublicComplaint::route('/create'),
      'edit' => Pages\EditPublicComplaint::route('/{record}/edit'),
    ];
  }
}
