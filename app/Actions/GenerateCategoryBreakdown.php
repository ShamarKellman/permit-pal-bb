<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Collection;

class GenerateCategoryBreakdown
{
    /**
     * @template TResponse of array{category_id: int, is_correct: bool}
     *
     * @param  Collection<int, TResponse>  $responses
     * @return array<int, array{category_id: int, correct: int, total: int, percentage: int}>
     */
    public function categoryBreakdown(Collection $responses): array
    {
        return $responses
            ->groupBy('category_id')
            ->map(function (Collection $group, int $categoryId): array {
                $correct = $group->filter(fn (array $response): bool => (bool) $response['is_correct'])->count();
                $total = $group->count();

                return [
                    'category_id' => $categoryId,
                    'correct' => $correct,
                    'total' => $total,
                    'percentage' => $total > 0 ? (int) round(($correct / $total) * 100) : 0,
                ];
            })
            ->values()
            ->all();
    }
}
