<?php

declare(strict_types=1);

use App\Actions\CalculateScore;

it('calculates score and pass flag correctly', function () {
    $responses = collect([
        ['is_correct' => true],
        ['is_correct' => true],
        ['is_correct' => false],
        ['is_correct' => true],
    ]);

    $result = (new CalculateScore)->calculate($responses, 4);
    expect($result['score'])->toBe(3);
    expect($result['total'])->toBe(4);
    expect($result['passed'])->toBeFalse();
});

it('marks passed when score meets the 15-question threshold', function () {
    $responses = collect(
        array_fill(0, 15, ['is_correct' => true]) + array_fill(15, 5, ['is_correct' => false])
    );

    $result = (new CalculateScore)->calculate($responses, 20);
    expect($result['passed'])->toBeTrue();
});
