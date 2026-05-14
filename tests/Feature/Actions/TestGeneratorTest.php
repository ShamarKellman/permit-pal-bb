<?php

declare(strict_types=1);

use App\Actions\TestGenerator;
use App\Models\Answer;
use App\Models\Question;

it('eager loads answers', function () {
    Question::factory()->count(5)->has(Answer::factory()->count(4))->create();
    $questions = new TestGenerator()->generate(5);
    expect($questions->first()->relationLoaded('answers'))->toBeTrue();
});

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
