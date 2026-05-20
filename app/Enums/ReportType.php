<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ReportType: string implements HasColor, HasLabel
{
    case WrongAnswer = 'wrong_answer';
    case Typo = 'typo';
    case UnclearQuestion = 'unclear_question';
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::WrongAnswer => 'Wrong Answer',
            self::Typo => 'Typo or Spelling Error',
            self::UnclearQuestion => 'Unclear Question',
            self::Other => 'Other',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::WrongAnswer => 'danger',
            self::Typo => 'warning',
            self::UnclearQuestion => 'info',
            self::Other => 'gray',
        };
    }
}
