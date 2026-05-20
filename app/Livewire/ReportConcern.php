<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Enums\ReportType;
use App\Models\QuestionReport;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Throttle;
use Livewire\Component;

class ReportConcern extends Component
{
    #[Locked]
    public int $questionId;

    public string $reportType = '';

    public string $description = '';

    public bool $submitted = false;

    public function rules(): array
    {
        return [
            'reportType' => ['required', new Enum(ReportType::class)],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    #[Throttle(5, 60)]
    public function submit(): void
    {
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
        $this->dispatch('report-submitted');
    }

    public function render(): View
    {
        return view('livewire.report-concern');
    }
}
