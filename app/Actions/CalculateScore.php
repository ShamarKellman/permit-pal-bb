<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Support\Collection;

class CalculateScore
{
    private const int PASS_THRESHOLD = 15;

    /**
     * @template TResponse of array{is_correct: bool}
     *
     * @param  Collection<int, TResponse>  $responses
     * @return array{score: int, total: int, passed: bool}
     */
    public function calculate(Collection $responses, int $total): array
    {
        $score = $responses->filter(fn (array $response) => $response['is_correct'])->count();

        return [
            'score' => $score,
            'total' => $total,
            'passed' => $score >= self::PASS_THRESHOLD,
        ];
    }
}
