<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TestSessionResource\Pages;
use App\Models\TestSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TestSessionResource extends Resource
{
    protected static ?string $model = TestSession::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('user.name')->label('User')->default('Guest'),
                TextColumn::make('score')
                    ->formatStateUsing(fn (int $state, TestSession $record) => "{$state} / {$record->total_questions}"),
                IconColumn::make('passed')->boolean(),
                TextColumn::make('completed_at')->dateTime()->sortable(),
            ])
            ->defaultSort('completed_at', 'desc')
            ->actions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestSessions::route('/'),
        ];
    }
}
