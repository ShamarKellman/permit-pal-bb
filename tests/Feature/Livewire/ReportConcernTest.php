<?php

declare(strict_types=1);

use App\Livewire\ReportConcern;
use App\Models\Question;
use App\Models\QuestionReport;
use App\Models\User;
use Illuminate\Validation\Rules\Enum;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

it('requires a report type before submitting', function () {
    $question = Question::factory()->create();

    livewire(ReportConcern::class, ['questionId' => $question->id])
        ->call('submit')
        ->assertHasErrors(['reportType' => 'required']);
});

it('rejects invalid report type', function () {
    $question = Question::factory()->create();

    livewire(ReportConcern::class, ['questionId' => $question->id])
        ->set('reportType', 'invalid_type')
        ->call('submit')
        ->assertHasErrors(['reportType' => Enum::class]);
});

it('rejects description over 500 characters', function () {
    $question = Question::factory()->create();

    livewire(ReportConcern::class, ['questionId' => $question->id])
        ->set('reportType', 'typo')
        ->set('description', str_repeat('a', 501))
        ->call('submit')
        ->assertHasErrors(['description' => 'max']);
});

it('can submit a report as a guest', function () {
    $question = Question::factory()->create();

    livewire(ReportConcern::class, ['questionId' => $question->id])
        ->set('reportType', 'wrong_answer')
        ->set('description', 'The correct answer should be option B.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    assertDatabaseHas(QuestionReport::class, [
        'question_id' => $question->id,
        'report_type' => 'wrong_answer',
        'description' => 'The correct answer should be option B.',
        'status' => 'pending',
        'user_id' => null,
    ]);
});

it('stores the user_id when authenticated', function () {
    $user = User::factory()->create();
    $question = Question::factory()->create();

    $this->actingAs($user);

    livewire(ReportConcern::class, ['questionId' => $question->id])
        ->set('reportType', 'typo')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    assertDatabaseHas(QuestionReport::class, [
        'question_id' => $question->id,
        'user_id' => $user->id,
    ]);
});

it('rate limits submit to 5 attempts per minute', function () {
    $question = Question::factory()->create();

    $component = livewire(ReportConcern::class, ['questionId' => $question->id]);

    foreach (range(1, 5) as $i) {
        $component->set('reportType', 'typo')->call('submit')->assertHasNoErrors();
    }

    $component->set('reportType', 'typo')->call('submit')->assertHasErrors(['reportType']);
});

it('accepts null description', function () {
    $question = Question::factory()->create();

    livewire(ReportConcern::class, ['questionId' => $question->id])
        ->set('reportType', 'other')
        ->set('description', '')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    assertDatabaseHas(QuestionReport::class, [
        'question_id' => $question->id,
        'description' => null,
    ]);
});
