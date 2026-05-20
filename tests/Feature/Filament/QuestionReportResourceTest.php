<?php

declare(strict_types=1);

use App\Filament\Resources\QuestionReportResource\Pages\ListQuestionReports;
use App\Filament\Resources\QuestionReportResource\Pages\ViewQuestionReport;
use App\Models\Admin;
use App\Models\QuestionReport;
use Filament\Actions\Testing\TestAction;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

beforeEach(fn () => $this->actingAs(Admin::factory()->create(), 'admin'));

it('can list question reports', function () {
    $reports = QuestionReport::factory()->count(3)->create();
    livewire(ListQuestionReports::class)->assertCanSeeTableRecords($reports);
});

it('can view a question report', function () {
    $report = QuestionReport::factory()->create([
        'report_type' => 'wrong_answer',
        'description' => 'The answer is wrong.',
        'status' => 'pending',
    ]);

    livewire(ViewQuestionReport::class, ['record' => $report->id])
        ->assertOk()
        ->assertSchemaStateSet([
            'report_type' => 'wrong_answer',
            'status' => 'pending',
        ]);
});

it('can mark a report as reviewed', function () {
    $report = QuestionReport::factory()->create(['status' => 'pending']);

    livewire(ListQuestionReports::class)
        ->callAction(TestAction::make('markReviewed')->table($report))
        ->assertNotified();

    assertDatabaseHas(QuestionReport::class, [
        'id' => $report->id,
        'status' => 'reviewed',
    ]);
});

it('does not show markReviewed for already-reviewed reports', function () {
    $report = QuestionReport::factory()->create(['status' => 'reviewed']);

    livewire(ListQuestionReports::class)
        ->assertTableActionHidden('markReviewed', $report);
});

it('can mark a report as resolved', function () {
    $report = QuestionReport::factory()->create(['status' => 'pending']);

    livewire(ListQuestionReports::class)
        ->callAction(TestAction::make('markResolved')->table($report))
        ->assertNotified();

    assertDatabaseHas(QuestionReport::class, [
        'id' => $report->id,
        'status' => 'resolved',
    ]);

    expect(QuestionReport::find($report->id)->resolved_at)->not->toBeNull();
});

it('does not show markResolved for already-resolved reports', function () {
    $report = QuestionReport::factory()->resolved()->create();

    livewire(ListQuestionReports::class)
        ->assertTableActionHidden('markResolved', $report);
});

it('can filter reports by status', function () {
    $pending = QuestionReport::factory()->create(['status' => 'pending']);
    $resolved = QuestionReport::factory()->resolved()->create();

    livewire(ListQuestionReports::class)
        ->filterTable('status', 'pending')
        ->assertCanSeeTableRecords([$pending])
        ->assertCanNotSeeTableRecords([$resolved]);
});
