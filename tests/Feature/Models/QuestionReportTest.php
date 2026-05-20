<?php

declare(strict_types=1);

use App\Enums\ReportStatus;
use App\Enums\ReportType;
use App\Models\Question;
use App\Models\QuestionReport;
use App\Models\User;

it('belongs to a question', function () {
    $report = QuestionReport::factory()->create();
    expect($report->question)->toBeInstanceOf(Question::class);
});

it('user is nullable', function () {
    $report = QuestionReport::factory()->create(['user_id' => null]);
    expect($report->user)->toBeNull();
});

it('belongs to a user when provided', function () {
    $user = User::factory()->create();
    $report = QuestionReport::factory()->create(['user_id' => $user->id]);
    expect($report->user)->toBeInstanceOf(User::class);
});

it('casts report_type to ReportType enum', function () {
    $report = QuestionReport::factory()->create(['report_type' => 'wrong_answer']);
    expect($report->report_type)->toBe(ReportType::WrongAnswer);
});

it('casts status to ReportStatus enum', function () {
    $report = QuestionReport::factory()->create(['status' => 'pending']);
    expect($report->status)->toBe(ReportStatus::Pending);
});

it('casts resolved_at to carbon', function () {
    $report = QuestionReport::factory()->resolved()->create();
    expect($report->resolved_at)->toBeInstanceOf(Carbon\CarbonImmutable::class);
});

it('question has many reports', function () {
    $question = Question::factory()->create();
    QuestionReport::factory()->count(3)->create(['question_id' => $question->id]);
    expect($question->fresh()->reports)->toHaveCount(3);
});
