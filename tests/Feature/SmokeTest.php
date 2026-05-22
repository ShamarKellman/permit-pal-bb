<?php

declare(strict_types=1);

use App\Models\User;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    Cache::flush();
    (new CategorySeeder)->run();
});

it('renders the home page for guests', function () {
    $this->get(route('home'))->assertOk();
});

it('redirects guests away from dashboard', function () {
    $this->get(route('dashboard'))->assertRedirect();
});

it('renders the dashboard for authenticated users', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('dashboard'))
        ->assertOk();
});

it('renders the study page with all categories', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('study'))
        ->assertOk();
});

it('renders each category study page', function (string $slug) {
    $this->actingAs(User::factory()->create())
        ->get(route('study.category', $slug))
        ->assertOk();
})->with([
    'road-signs',
    'traffic-lights-signals',
    'speed-limits',
    'roundabouts-junctions',
    'overtaking',
    'parking',
    'seatbelts-child-restraints',
    'pedestrians-cyclists',
    'learner-drivers',
    'vehicle-lighting',
    'safe-driving-practices',
    'animals-on-the-road',
]);

it('renders the practice test page', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('test'))
        ->assertOk();
});
