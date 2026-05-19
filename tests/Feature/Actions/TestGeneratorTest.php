<?php

declare(strict_types=1);

use App\Actions\TestGenerator;
use App\Models\Answer;
use App\Models\Category;
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

it('filters questions by category', function () {
    $target = Category::factory()->create();
    $other = Category::factory()->create();

    Question::factory()->count(5)->for($target)->has(Answer::factory()->count(4))->create();
    Question::factory()->count(5)->for($other)->has(Answer::factory()->count(4))->create();

    $questions = new TestGenerator()->generate(10, $target->id);
    expect($questions)->toHaveCount(5);
    $questions->each(fn ($q) => expect($q->category_id)->toBe($target->id));
});

it('returns all categories when no category filter given', function () {
    $cat1 = Category::factory()->create();
    $cat2 = Category::factory()->create();

    Question::factory()->count(5)->for($cat1)->has(Answer::factory()->count(4))->create();
    Question::factory()->count(5)->for($cat2)->has(Answer::factory()->count(4))->create();

    $questions = new TestGenerator()->generate(10);
    $categoryIds = $questions->pluck('category_id')->unique()->values();
    expect($categoryIds)->toHaveCount(2);
});
