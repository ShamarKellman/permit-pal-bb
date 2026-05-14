<?php

declare(strict_types=1);

use App\Actions\GenerateCategoryBreakdown;

it('groups responses by category', function () {
    $responses = collect([
        ['category_id' => 1, 'is_correct' => true],
        ['category_id' => 1, 'is_correct' => false],
        ['category_id' => 2, 'is_correct' => true],
    ]);

    $result = (new GenerateCategoryBreakdown)->categoryBreakdown($responses);

    expect($result)->toHaveCount(2);
});

it('calculates correct count per category', function () {
    $responses = collect([
        ['category_id' => 1, 'is_correct' => true],
        ['category_id' => 1, 'is_correct' => true],
        ['category_id' => 1, 'is_correct' => false],
    ]);

    $result = (new GenerateCategoryBreakdown)->categoryBreakdown($responses);

    expect($result[0])->toMatchArray([
        'category_id' => 1,
        'correct' => 2,
        'total' => 3,
        'percentage' => 67,
    ]);
});

it('calculates 100 percentage when all correct', function () {
    $responses = collect([
        ['category_id' => 5, 'is_correct' => true],
        ['category_id' => 5, 'is_correct' => true],
    ]);

    $result = (new GenerateCategoryBreakdown)->categoryBreakdown($responses);

    expect($result[0]['percentage'])->toBe(100);
});

it('calculates 0 percentage when none correct', function () {
    $responses = collect([
        ['category_id' => 3, 'is_correct' => false],
        ['category_id' => 3, 'is_correct' => false],
    ]);

    $result = (new GenerateCategoryBreakdown)->categoryBreakdown($responses);

    expect($result[0]['percentage'])->toBe(0);
});

it('returns empty array for empty responses', function () {
    $result = (new GenerateCategoryBreakdown)->categoryBreakdown(collect());

    expect($result)->toBeEmpty();
});
