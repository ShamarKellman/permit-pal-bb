<?php

declare(strict_types=1);

namespace App\Filament\Resources\TestSessionResource\Pages;

use App\Filament\Resources\TestSessionResource;
use Filament\Resources\Pages\ListRecords;

class ListTestSessions extends ListRecords
{
    protected static string $resource = TestSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
