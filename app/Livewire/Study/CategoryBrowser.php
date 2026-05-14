<?php

declare(strict_types=1);

namespace App\Livewire\Study;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class CategoryBrowser extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.study.category-browser', [
            'categories' => $this->categories(),
        ]);
    }

    /** @return Collection<int, Category> */
    private function categories(): Collection
    {
        return Cache::remember('categories.with_counts', 300, fn () => Category::withCount([
            'questions as active_questions_count' => fn (Builder $q) => $q->where('is_active', true),
        ])
            ->orderBy('sort_order')
            ->get());
    }
}
