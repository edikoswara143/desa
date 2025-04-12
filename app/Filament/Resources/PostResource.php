<?php

namespace App\Filament\Resources;

use App\Enums\PostStatus;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Categorie;
use App\Models\Category;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PostResource extends Resource
{
  protected static ?string $model = Post::class;

  protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
  protected static ?string $navigationGroup = 'Post';
  protected static ?int $navigationSort = 2;
  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('title')
          ->required()
          ->live(onBlur: true)
          ->afterStateUpdated(function (Set $set, $state) {
            $set('slug', Str::slug($state));
          })
          ->required()
          ->maxLength(255),
        Forms\Components\TextInput::make('slug')
          ->unique(ignoreRecord: true)
          ->readOnly()
          ->maxLength(255),
        Forms\Components\Select::make('categories_id')
          ->options(Category::all()->pluck('name', 'id'))
          ->label('Category')
          ->searchable()
          ->required()
          ->columnSpanFull()
          ->preload()
          ->native(true),
        RichEditor::make('content')
          ->required()
          ->columnSpanFull(),
        FileUpload::make('thumbnail')
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
              ->prepend('post-thumbnail-' . now()->timestamp),
          )
          ->columnSpanFull(),
        Forms\Components\Select::make('publish')
          ->options(PostStatus::class)
          ->columnSpanFull(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\ImageColumn::make('thumbnail')
          ->searchable(),
        Tables\Columns\TextColumn::make('title')
          ->words(4)
          ->searchable(),
        Tables\Columns\TextColumn::make('slug')
          ->toggleable(isToggledHiddenByDefault: true)
          ->searchable(),
        Tables\Columns\TextColumn::make('categories.name')
          ->searchable(),
        Tables\Columns\TextColumn::make('user.name')
          ->searchable(),
        Tables\Columns\TextColumn::make('publish')
          ->badge(),
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

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListPosts::route('/'),
      'create' => Pages\CreatePost::route('/create'),
      'edit' => Pages\EditPost::route('/{record}/edit'),
    ];
  }
}
