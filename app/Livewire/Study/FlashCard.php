<?php

declare(strict_types=1);

namespace App\Livewire\Study;

use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class FlashCard extends Component
{
    public string $categorySlug = '';

    public int $currentIndex = 0;

    public bool $isFlipped = false;

    /** @var Collection<int, Question> */
    #[Locked]
    public Collection $questions;

    public function mount(string $categorySlug): void
    {
        $this->categorySlug = $categorySlug;
        $this->questions = Question::query()
            ->active()
            ->whereHas('category', fn (Builder $query): Builder => $query->where('slug', $categorySlug))
            ->with('answers')
            ->get();
    }

    #[Computed]
    public function currentQuestion(): ?Question
    {
        return $this->questions[$this->currentIndex] ?? null;
    }

    public function flip(): void
    {
        $this->isFlipped = ! $this->isFlipped;
    }

    public function next(): void
    {
        if ($this->currentIndex < $this->questions->count() - 1) {
            $this->currentIndex++;
            $this->isFlipped = false;
        }
    }

    public function previous(): void
    {
        if ($this->currentIndex > 0) {
            $this->currentIndex--;
            $this->isFlipped = false;
        }
    }

    public function render(): View
    {
        return view('livewire.study.flash-card');
    }
}
