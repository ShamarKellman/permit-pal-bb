<?php

declare(strict_types=1);

use App\Models\TestSession;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    Cache::forget('pass_rate_30');
});

it('can belong to a user', function () {
    $session = TestSession::factory()->create();
    expect($session->load('user')->user)->toBeInstanceOf(User::class);
});

it('supports guest sessions with no user', function () {
    $session = TestSession::factory()->guest()->create();
    expect($session->user_id)->toBeNull();
    expect($session->session_token)->not->toBeNull();
});

it('today builder method returns only todays sessions', function () {
    TestSession::factory()->create(['started_at' => now()]);
    TestSession::factory()->create(['started_at' => now()->subDays(2)]);
    expect(TestSession::today()->count())->toBe(1);
});

it('calculates pass rate correctly', function () {
    TestSession::factory()->passed()->count(2)->create(['started_at' => now()]);
    TestSession::factory()->failed()->create(['started_at' => now()]);
    expect(TestSession::recentPassRate())->toBe(67);
});
