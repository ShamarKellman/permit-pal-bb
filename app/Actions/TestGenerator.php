<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TestGenerator
{
    /**
     * @return Collection<int, Question>
     */
    public function generate(int $count = 20, ?int $categoryId = null): Collection
    {
        return Question::query()
            ->active()
            ->when($categoryId !== null, fn (Builder $query): Builder => $query->forCategory((int) $categoryId))
            ->with('answers')
            ->inRandomOrder()
            ->limit($count)
            ->get();
    }
}
