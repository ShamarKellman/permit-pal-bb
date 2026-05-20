<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Filament\Resources\QuestionReportResource\Pages\ListQuestionReports;
use App\Filament\Resources\QuestionReportResource\Pages\ViewQuestionReport;
use App\Models\QuestionReport;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuestionReportResource extends Resource
{
    protected static ?string $model = QuestionReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFlag;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::query()->where('status', 'pending')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getNavigationBadge() !== null ? 'warning' : null;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                TextEntry::make('question.question_text')
                    ->label('Question')
                    ->columnSpanFull(),
                TextEntry::make('report_type')
                    ->badge()
                    ->state(fn (QuestionReport $record): string => $record->report_type->value)
                    ->formatStateUsing(fn (string $state): string => ReportType::from($state)->label()),
                TextEntry::make('status')
                    ->badge()
                    ->state(fn (QuestionReport $record): string => $record->status->value)
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'reviewed' => 'info',
                        'resolved' => 'success',
                        default => 'gray',
                    }),
                TextEntry::make('description')
                    ->placeholder('No description provided.')
                    ->columnSpanFull(),
                TextEntry::make('user.name')
                    ->label('Reported By')
                    ->placeholder('Guest'),
                TextEntry::make('created_at')->dateTime(),
                TextEntry::make('resolved_at')
                    ->dateTime()
                    ->placeholder('Not resolved yet.'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('question.question_text')
                    ->label('Question')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('report_type')
                    ->badge()
                    ->formatStateUsing(fn (ReportType $state): string => $state->label()),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (ReportStatus $state): string => match ($state) {
                        ReportStatus::Pending => 'warning',
                        ReportStatus::Reviewed => 'info',
                        ReportStatus::Resolved => 'success',
                    }),
                TextColumn::make('description')->limit(40)->placeholder('—'),
                TextColumn::make('created_at')->since()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(
                        collect(ReportStatus::cases())
                            ->mapWithKeys(fn (ReportStatus $case): array => [$case->value => ucfirst($case->value)])
                            ->all()
                    ),
                SelectFilter::make('report_type')
                    ->options(
                        collect(ReportType::cases())
                            ->mapWithKeys(fn (ReportType $case): array => [$case->value => $case->label()])
                            ->all()
                    ),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('markReviewed')
                    ->label('Mark Reviewed')
                    ->icon(Heroicon::OutlinedCheck)
                    ->visible(fn (QuestionReport $record): bool => $record->status === ReportStatus::Pending)
                    ->action(function (QuestionReport $record): void {
                        $record->update(['status' => ReportStatus::Reviewed->value]);

                        Notification::make()
                            ->title('Marked as reviewed')
                            ->success()
                            ->send();
                    }),
                Action::make('markResolved')
                    ->label('Mark Resolved')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (QuestionReport $record): bool => $record->status !== ReportStatus::Resolved)
                    ->action(function (QuestionReport $record): void {
                        $record->update([
                            'status' => ReportStatus::Resolved->value,
                            'resolved_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Marked as resolved')
                            ->success()
                            ->send();
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuestionReports::route('/'),
            'view' => ViewQuestionReport::route('/{record}'),
        ];
    }
}
