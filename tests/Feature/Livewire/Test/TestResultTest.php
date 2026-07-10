<?php

declare(strict_types=1);

use App\Livewire\Test\TestResult;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\TestSession;
use App\Models\User;

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

it('questionReview returns empty array when no session', function () {
    livewire(TestResult::class)
        ->assertSet('questionReview', []);
});

it('questionReview shapes correct response correctly', function () {
    $category = Category::factory()->create(['name' => 'Road Signs']);
    $question = Question::factory()->for($category)->create(['question_text' => 'What does a red light mean?']);
    $correctAnswer = Answer::factory()->correct()->for($question)->create([
        'answer_text' => 'Stop',
        'explanation' => 'Red means stop.',
    ]);
    Answer::factory()->for($question)->create(['answer_text' => 'Go']);

    $session = TestSession::factory()->create();
    $session->responses()->create([
        'question_id' => $question->id,
        'answer_id' => $correctAnswer->id,
        'is_correct' => true,
    ]);

    session(['last_test_session_id' => $session->id]);

    $review = livewire(TestResult::class)->get('questionReview');

    expect($review)->toHaveCount(1)
        ->and($review[0])->toMatchArray([
            'question_text' => 'What does a red light mean?',
            'user_answer' => 'Stop',
            'correct_answer' => 'Stop',
            'is_correct' => true,
            'explanation' => 'Red means stop.',
        ]);
});

it('questionReview shapes incorrect response correctly', function () {
    $category = Category::factory()->create();
    $question = Question::factory()->for($category)->create(['question_text' => 'What does a green light mean?']);
    $correctAnswer = Answer::factory()->correct()->for($question)->create([
        'answer_text' => 'Go',
        'explanation' => null,
    ]);
    $wrongAnswer = Answer::factory()->for($question)->create(['answer_text' => 'Stop']);

    $session = TestSession::factory()->create();
    $session->responses()->create([
        'question_id' => $question->id,
        'answer_id' => $wrongAnswer->id,
        'is_correct' => false,
    ]);

    session(['last_test_session_id' => $session->id]);

    $review = livewire(TestResult::class)->get('questionReview');

    expect($review)->toHaveCount(1)
        ->and($review[0])->toMatchArray([
            'question_text' => 'What does a green light mean?',
            'user_answer' => 'Stop',
            'correct_answer' => 'Go',
            'is_correct' => false,
            'explanation' => null,
        ]);
});

it('authenticated user cannot view another users session', function () {
    $owner = User::factory()->create();
    $viewer = User::factory()->create();

    $session = TestSession::factory()->for($owner)->create();
    session(['last_test_session_id' => $session->id]);

    $this->actingAs($viewer);

    livewire(TestResult::class)
        ->assertSet('session', null);
});

it('authenticated user can view their own session', function () {
    $user = User::factory()->create();
    $session = TestSession::factory()->for($user)->create();
    session(['last_test_session_id' => $session->id]);

    $this->actingAs($user);

    livewire(TestResult::class)
        ->assertSet('session.id', $session->id);
});

it('setFilter changes filter property', function () {
    livewire(TestResult::class)
        ->call('setFilter', 'incorrect')
        ->assertSet('filter', 'incorrect');
});

it('questionReview filters to only incorrect when filter is incorrect', function () {
    $category = Category::factory()->create();
    $question = Question::factory()->for($category)->create();
    $correctAnswer = Answer::factory()->correct()->for($question)->create(['answer_text' => 'Right']);
    $wrongAnswer = Answer::factory()->for($question)->create(['answer_text' => 'Wrong']);

    $session = TestSession::factory()->create();
    $session->responses()->createMany([
        ['question_id' => $question->id, 'answer_id' => $correctAnswer->id, 'is_correct' => true],
        ['question_id' => $question->id, 'answer_id' => $wrongAnswer->id, 'is_correct' => false],
    ]);

    session(['last_test_session_id' => $session->id]);

    $component = livewire(TestResult::class);

    expect($component->get('questionReview'))->toHaveCount(2);

    $component->call('setFilter', 'incorrect');
    expect($component->get('questionReview'))->toHaveCount(1)
        ->and($component->get('questionReview')[0]['is_correct'])->toBeFalse();

    $component->call('setFilter', 'correct');
    expect($component->get('questionReview'))->toHaveCount(1)
        ->and($component->get('questionReview')[0]['is_correct'])->toBeTrue();
});

it('shows the question sign image in the review', function () {
    $category = Category::factory()->create();
    $question = Question::factory()->for($category)->create(['image_path' => 'signs/no-entry.svg']);
    $answer = Answer::factory()->correct()->for($question)->create();

    $session = TestSession::factory()->create();
    $session->responses()->create([
        'question_id' => $question->id,
        'answer_id' => $answer->id,
        'is_correct' => true,
    ]);

    session(['last_test_session_id' => $session->id]);

    livewire(TestResult::class)->assertSeeHtml('signs/no-entry.svg');
});
