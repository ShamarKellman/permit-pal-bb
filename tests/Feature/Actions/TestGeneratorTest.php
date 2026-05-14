<?php

declare(strict_types=1);

use App\Actions\TestGenerator;
use App\Models\Answer;
use App\Models\Question;
use App\Services\ScoreCalculatorService;

it('generates the requested number of questions', function () {
    Question::factory()->count(25)->has(Answer::factory()->count(4))->create();
    expect(new TestGenerator()->generate(20))->toHaveCount(20);
});

it('only includes active questions', function () {
    Question::factory()->count(10)->inactive()->has(Answer::factory()->count(4))->create();
    Question::factory()->count(5)->has(Answer::factory()->count(4))->create();

    $questions = new TestGenerator()->generate(5);
    expect($questions)->toHaveCount(5);
    $questions->each(fn ($q) => expect($q->is_active)->toBeTrue());
});

it('eager loads answers', function () {
    Question::factory()->count(5)->has(Answer::factory()->count(4))->create();
    $questions = new TestGenerator()->generate(5);
    expect($questions->first()->relationLoaded('answers'))->toBeTrue();
});

it('calculates score and pass flag correctly', function () {
    $responses = collect([
        ['is_correct' => true],
        ['is_correct' => true],
        ['is_correct' => false],
        ['is_correct' => true],
    ]);

    $result = ScoreCalculatorService::calculate($responses, 4);
    expect($result['score'])->toBe(3);
    expect($result['total'])->toBe(4);
    expect($result['passed'])->toBeFalse();
});

it('marks passed when score meets the 15-question threshold', function () {
    $responses = collect(
        array_fill(0, 15, ['is_correct' => true]) + array_fill(15, 5, ['is_correct' => false])
    );

    $result = ScoreCalculatorService::calculate($responses, 20);
    expect($result['passed'])->toBeTrue();
});
