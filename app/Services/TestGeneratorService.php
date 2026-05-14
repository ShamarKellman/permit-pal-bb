<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class TestGeneratorService
{
    /**
     * @return Collection<int, Question>
     */
    public static function generate(int $count = 20): Collection
    {
        return Question::active()
            ->with('answers')
            ->inRandomOrder()
            ->limit($count)
            ->get();
    }
}
