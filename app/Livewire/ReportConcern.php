<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\QuestionReport;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReportConcern extends Component
{
    #[Locked]
    public int $questionId;

    #[Validate('required|in:wrong_answer,typo,unclear_question,other')]
    public string $reportType = '';

    #[Validate('nullable|string|max:500')]
    public string $description = '';

    public bool $submitted = false;

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
