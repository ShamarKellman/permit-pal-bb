<?php

declare(strict_types=1);

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;

it('belongs to a category', function () {
    $question = Question::factory()->create();
    expect($question->load('category')->category)->toBeInstanceOf(Category::class);
});

it('has many answers', function () {
    $question = Question::factory()->create();
    Answer::factory()->count(4)->create(['question_id' => $question->id]);
    expect($question->fresh()->load('answers')->answers)->toHaveCount(4);
});

it('active builder method filters out inactive questions', function () {
    Question::factory()->create(['is_active' => true]);
    Question::factory()->inactive()->create();
    expect(Question::active()->count())->toBe(1);
});
