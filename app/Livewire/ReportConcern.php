<?php

declare(strict_types=1);

namespace App\Livewire;

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
        // stub - database logic intentionally empty
    }

    public function render(): View
    {
        return view('livewire.report-concern');
    }
}
