<?php

declare(strict_types=1);

namespace App\Livewire\Test;

use App\Actions\GenerateCategoryBreakdown;
use App\Models\TestResponse;
use App\Models\TestSession;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Test Result')]
class TestResult extends Component
{
    #[Locked]
    public ?TestSession $session = null;

    public string $filter = 'all';

    private GenerateCategoryBreakdown $generateCategoryBreakdown;

    public function boot(GenerateCategoryBreakdown $generateCategoryBreakdown): void
    {
        $this->generateCategoryBreakdown = $generateCategoryBreakdown;
    }

    public function mount(): void
    {
        $sessionId = session('last_test_session_id');

        if (! $sessionId) {
            return;
        }

        /** @var TestSession|null $session */
        $session = TestSession::query()
            ->with([
                'responses.question.category',
                'responses.question.answers',
                'responses.answer',
            ])
            ->when(auth()->check(), fn ($q) => $q->where('user_id', auth()->id()))
            ->find($sessionId);
        $this->session = $session;
    }

    /** @return array<int, array{category: string, correct: int, total: int, percentage: int}> */
    #[Computed]
    public function categoryBreakdown(): array
    {
        if (! $this->session) {
            return [];
        }

        $categoryNames = $this->session->responses
            ->mapWithKeys(fn (TestResponse $response): array => [
                $response->question?->category_id => $response->question?->category->name ?? 'Unknown',
            ]);

        $rawResponses = $this->session->responses
            ->filter(fn (TestResponse $response): bool => $response->question?->category_id !== null)
            ->map(fn (TestResponse $response): array => [
                'category_id' => (int) $response->question?->category_id,
                'is_correct' => $response->is_correct,
            ]);

        return array_map(
            fn (array $breakdown): array => [
                'category' => $categoryNames[$breakdown['category_id']] ?? 'Unknown',
                'correct' => $breakdown['correct'],
                'total' => $breakdown['total'],
                'percentage' => $breakdown['percentage'],
            ],
            $this->generateCategoryBreakdown->categoryBreakdown($rawResponses)
        );
    }

    /**
     * @return array<int, array{question_text: string, user_answer: string, correct_answer: string, is_correct: bool, explanation: string|null}>
     */
    #[Computed]
    public function questionReview(): array
    {
        if (! $this->session) {
            return [];
        }

        $rows = $this->session->responses->map(function (TestResponse $response): array {
            $correctAnswer = $response->question?->answers->firstWhere('is_correct', true);

            return [
                'question_text' => $response->question->question_text ?? '',
                'user_answer' => $response->answer->answer_text ?? '',
                'correct_answer' => $correctAnswer->answer_text ?? '',
                'is_correct' => $response->is_correct,
                'explanation' => $correctAnswer?->explanation,
            ];
        });

        return match ($this->filter) {
            'correct' => $rows->filter(fn (array $row): bool => $row['is_correct'])->values()->all(),
            'incorrect' => $rows->filter(fn (array $row): bool => ! $row['is_correct'])->values()->all(),
            default => $rows->all(),
        };
    }

    public function setFilter(string $filter): void
    {
        $this->filter = in_array($filter, ['all', 'correct', 'incorrect'], true) ? $filter : 'all';
        unset($this->questionReview);
    }

    public function render(): View
    {
        return view('livewire.test.test-result');
    }
}
