<?php

declare(strict_types=1);

namespace App\Livewire\Test;

use Livewire\Component;

class TestResult extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('livewire.test.test-result');
    }
}
