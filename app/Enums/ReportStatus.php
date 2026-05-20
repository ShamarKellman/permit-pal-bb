<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ReportStatus: string implements HasColor, HasLabel
{
    case Pending = 'pending';
    case Reviewed = 'reviewed';
    case Resolved = 'resolved';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Reviewed => 'Reviewed',
            self::Resolved => 'Resolved',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Reviewed => 'info',
            self::Resolved => 'success',
        };
    }
}
