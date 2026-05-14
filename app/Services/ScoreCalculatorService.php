<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;

class ScoreCalculatorService
{
    private const int PASS_THRESHOLD = 15;

    /**
     * @param  Collection<int, array{is_correct: bool}>  $responses
     * @return array{score: int, total: int, passed: bool}
     */
    public static function calculate(Collection $responses, int $total): array
    {
        $score = $responses->filter(fn (array $responses) => $responses['is_correct'])->count();

        return [
            'score' => $score,
            'total' => $total,
            'passed' => $score >= self::PASS_THRESHOLD,
        ];
    }

    /**
     * @param  Collection<int, array{category_id: int, is_correct: bool}>  $responses
     * @return array<int, array{category_id: int, correct: int, total: int, percentage: int}>
     */
    public static function categoryBreakdown(Collection $responses): array
    {
        return $responses
            ->groupBy('category_id')
            ->map(function (Collection $group, int $categoryId) {
                $correct = $group->filter(fn (array $responses) => (bool) $responses['is_correct'])->count();
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
