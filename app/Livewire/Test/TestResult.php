<?php

declare(strict_types=1);

namespace App\Livewire\Test;

use App\Models\Category;
use App\Models\TestResponse;
use App\Models\TestSession;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Test Result')]
class TestResult extends Component
{
    #[Locked]
    public ?TestSession $session = null;

    public function mount(): void
    {
        $sessionId = session('last_test_session_id');

        if (! $sessionId) {
            return;
        }

        /** @var TestSession|null $session */
        $session = TestSession::with('responses.question.category')->find($sessionId);
        $this->session = $session;
    }

    /** @return array<int, array{category: string, correct: int, total: int, percentage: int}> */
    #[Computed]
    public function categoryBreakdown(): array
    {
        if (! $this->session) {
            return [];
        }

        return $this->session->responses
            ->groupBy(fn (TestResponse $r) => (string) $r->question?->category_id)
            ->map(function ($group, $categoryId) {
                $correct = (int) $group->filter(fn (TestResponse $r) => $r->is_correct)->count();
                $total = (int) $group->count();

                /** @var Category|null $foundCategory */
                $foundCategory = Category::query()->find($categoryId);
                $categoryName = $foundCategory !== null ? $foundCategory->name : 'Unknown';

                return [
                    'category' => $categoryName,
                    'correct' => $correct,
                    'total' => $total,
                    'percentage' => $total > 0 ? (int) round(($correct / $total) * 100) : 0,
                ];
            })
            ->values()
            ->all();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.test.test-result');
    }
}
