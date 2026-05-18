<?php

declare(strict_types=1);

use App\Livewire\Test\PracticeTest;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;

use function Pest\Livewire\livewire;

beforeEach(function () {
    Question::factory()->count(20)
        ->has(Answer::factory()->count(3))
        ->has(Answer::factory()->correct()->count(1))
        ->create();
});

it('mounts with 20 questions', function () {
    livewire(PracticeTest::class)->assertSet('totalQuestions', 20);
});

it('requires an answer before submitting', function () {
    livewire(PracticeTest::class)
        ->call('submitAnswer')
        ->assertHasErrors(['selectedAnswer']);
});

it('advances to next question after submitting an answer', function () {
    $component = livewire(PracticeTest::class);
    $answer = $component->get('questions')[0]->answers->first();

    $component
        ->set('selectedAnswer', $answer->id)
        ->call('submitAnswer')
        ->assertSet('currentIndex', 1)
        ->assertSet('selectedAnswer', null);
});

it('redirects to test result after answering all questions', function () {
    $component = livewire(PracticeTest::class);
    $questions = $component->get('questions');

    foreach ($questions as $question) {
        $component
            ->set('selectedAnswer', $question->answers->first()->id)
            ->call('submitAnswer');
    }

    $component->assertRedirect(route('test.result'));
});

it('filters questions by category slug from url', function () {
    $category = Category::factory()->create(['slug' => 'road-signs']);

    Question::factory()->count(10)
        ->for($category)
        ->has(Answer::factory()->count(3))
        ->has(Answer::factory()->correct()->count(1))
        ->create();

    $component = livewire(PracticeTest::class, ['categorySlug' => 'road-signs']);

    $questions = $component->get('questions');
    $questions->each(fn ($q) => expect($q->category_id)->toBe($category->id));
    expect($component->get('categoryName'))->toBe($category->name);
});

it('ignores unknown category slug and loads all questions', function () {
    $component = livewire(PracticeTest::class, ['categorySlug' => 'does-not-exist']);

    expect($component->get('categoryName'))->toBeNull();
    expect($component->get('questions'))->toHaveCount(20);
});

it('ignores category slug with invalid format', function () {
    $component = livewire(PracticeTest::class, ['categorySlug' => '<script>alert(1)</script>']);

    expect($component->get('categoryName'))->toBeNull();
    expect($component->get('questions'))->toHaveCount(20);
});
