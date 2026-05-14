<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class TestGenerator
{
    /**
     * @return Collection<int, Question>
     */
    public function generate(int $count = 20): Collection
    {
        return Question::query()
            ->active()
            ->with('answers')
            ->inRandomOrder()
            ->limit($count)
            ->get();
    }
}
