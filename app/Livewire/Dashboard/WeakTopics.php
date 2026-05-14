<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use App\Models\Category;
use App\Models\TestResponse;
use App\Models\TestSession;
use Illuminate\Support\Collection;
use Livewire\Component;

class WeakTopics extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.dashboard.weak-topics', [
            'weakCategories' => $this->weakCategories(),
        ]);
    }

    /**
     * @return Collection<int, array{category: Category, percentage: int}>
     */
    private function weakCategories(): Collection
    {
        $sessionIds = TestSession::where('user_id', auth()->id())
            ->completed()
            ->pluck('id');

        /** @var Collection<int, array{category: Category, percentage: int}> $result */
        $result = TestResponse::whereIn('test_session_id', $sessionIds)
            ->with('question.category')
            ->get()
            ->filter(fn (TestResponse $r) => $r->question !== null && $r->question->category !== null)
            ->groupBy(fn (TestResponse $r) => (string) $r->question?->category_id)
            ->map(function (Collection $group): array {
                $correct = $group->filter(fn (TestResponse $r) => $r->is_correct)->count();
                $total = $group->count();
                $percentage = $total > 0 ? (int) round(($correct / $total) * 100) : 0;

                /** @var TestResponse $first */
                $first = $group->first();

                /** @var \App\Models\Question $question */
                $question = $first->question;

                /** @var Category $category */
                $category = $question->category;

                return [
                    'category' => $category,
                    'percentage' => $percentage,
                ];
            })
            ->filter(fn (array $item) => $item['percentage'] < 70)
            ->sortBy('percentage')
            ->values();

        return $result;
    }
}
