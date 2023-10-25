<?php

namespace App\Filament\Resources;

use App\Enums\BookTypeEnum;
use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use App\Models\Genre;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Enum;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('author_id')
                    ->relationship('author', 'username')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->unique(ignorable: fn ($record) => $record)
                    ->maxLength(255),
                Forms\Components\Select::make('genre_id')
                    ->relationship('genres', 'name')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options(BookTypeEnum::class),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author.username')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('genres.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d.m.Y (в H:i:s)')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d.m.Y (в H:i:s)')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(BookTypeEnum::class),
                Tables\Filters\SelectFilter::make('genres')
                    ->relationship('genres', 'name'),
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
