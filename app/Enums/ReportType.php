<?php

declare(strict_types=1);

namespace App\Enums;

enum ReportType: string
{
    case WrongAnswer = 'wrong_answer';
    case Typo = 'typo';
    case UnclearQuestion = 'unclear_question';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::WrongAnswer => 'Wrong Answer',
            self::Typo => 'Typo or Spelling Error',
            self::UnclearQuestion => 'Unclear Question',
            self::Other => 'Other',
        };
    }
}
