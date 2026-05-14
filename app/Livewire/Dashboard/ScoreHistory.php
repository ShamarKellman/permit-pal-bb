<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use App\Models\TestSession;
use Illuminate\Support\Collection;
use Livewire\Component;

class ScoreHistory extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.dashboard.score-history', [
            'sessions' => $this->sessions(),
        ]);
    }

    /**
     * @return Collection<int, TestSession>
     */
    private function sessions(): Collection
    {
        return TestSession::where('user_id', auth()->id())
            ->completed()
            ->latest('completed_at')
            ->limit(10)
            ->get();
    }
}
