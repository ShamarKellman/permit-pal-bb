<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Enums\ReportType;
use App\Models\QuestionReport;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ReportConcern extends Component
{
    use WithRateLimiting;

    #[Locked]
    public int $questionId;

    public string $reportType = '';

    public string $description = '';

    public bool $submitted = false;

    /** @return array<string, array<int, string|Enum>> */
    public function rules(): array
    {
        return [
            'reportType' => ['required', new Enum(ReportType::class)],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function submit(): void
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $seconds = is_int($exception->secondsUntilAvailable) ? $exception->secondsUntilAvailable : 60;
            $this->addError('reportType', 'Too many reports. Try again in '.$seconds.' seconds.');

            return;
        }

        $this->validate();

        QuestionReport::query()->create([
            'question_id' => $this->questionId,
            'user_id' => auth()->id(),
            'report_type' => $this->reportType,
            'description' => $this->description !== '' ? $this->description : null,
            'status' => 'pending',
        ]);

        $this->submitted = true;
        $this->reportType = '';
        $this->description = '';
        $this->dispatch('modal-close', name: 'report-concern-'.$this->questionId);
    }

    public function render(): View
    {
        return view('livewire.report-concern');
    }
}
