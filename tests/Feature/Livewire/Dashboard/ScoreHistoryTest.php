<?php

declare(strict_types=1);

use App\Livewire\Dashboard\ScoreHistory;
use App\Models\TestSession;
use App\Models\User;

use function Pest\Livewire\livewire;

it('shows completed test sessions for authenticated user', function () {
    $user = User::factory()->create();
    $session = TestSession::factory()->create(['user_id' => $user->id, 'score' => 14]);

    $this->actingAs($user);

    livewire(ScoreHistory::class)->assertSee('14/20');
});

it('does not show other users sessions', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    TestSession::factory()->create(['user_id' => $other->id, 'score' => 19]);

    $this->actingAs($user);

    livewire(ScoreHistory::class)->assertDontSee('19/20');
});
