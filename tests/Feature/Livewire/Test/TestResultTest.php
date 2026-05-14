<?php

declare(strict_types=1);

use App\Livewire\Test\TestResult;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\TestSession;

use function Pest\Livewire\livewire;

it('renders with no session when flash data is absent', function () {
    livewire(TestResult::class)
        ->assertSet('session', null);
});

it('loads session on mount when flash data is present', function () {
    $session = TestSession::factory()->create();
    session(['last_test_session_id' => $session->id]);

    livewire(TestResult::class)
        ->assertSet('session.id', $session->id);
});

it('returns empty category breakdown when no session', function () {
    livewire(TestResult::class)
        ->assertSet('categoryBreakdown', []);
});

it('returns category breakdown with correct counts and percentage', function () {
    $category = Category::factory()->create(['name' => 'Road Signs']);
    $question = Question::factory()->for($category)->create();
    $correctAnswer = Answer::factory()->correct()->for($question)->create();
    $wrongAnswer = Answer::factory()->for($question)->create();

    $session = TestSession::factory()->create();
    $session->responses()->createMany([
        ['question_id' => $question->id, 'answer_id' => $correctAnswer->id, 'is_correct' => true],
        ['question_id' => $question->id, 'answer_id' => $wrongAnswer->id, 'is_correct' => false],
    ]);

    session(['last_test_session_id' => $session->id]);

    $breakdown = livewire(TestResult::class)->get('categoryBreakdown');

    expect($breakdown)->toHaveCount(1)
        ->and($breakdown[0])->toMatchArray([
            'category' => 'Road Signs',
            'correct' => 1,
            'total' => 2,
            'percentage' => 50,
        ]);
});

it('groups responses across multiple categories', function () {
    $catA = Category::factory()->create();
    $catB = Category::factory()->create();
    $questionA = Question::factory()->for($catA)->create();
    $questionB = Question::factory()->for($catB)->create();
    $correctAnswer = Answer::factory()->correct()->for($questionA)->create();
    $wrongAnswer = Answer::factory()->for($questionB)->create();

    $session = TestSession::factory()->create();
    $session->responses()->createMany([
        ['question_id' => $questionA->id, 'answer_id' => $correctAnswer->id, 'is_correct' => true],
        ['question_id' => $questionB->id, 'answer_id' => $wrongAnswer->id, 'is_correct' => false],
    ]);

    session(['last_test_session_id' => $session->id]);

    $breakdown = livewire(TestResult::class)->get('categoryBreakdown');

    expect($breakdown)->toHaveCount(2);
});
