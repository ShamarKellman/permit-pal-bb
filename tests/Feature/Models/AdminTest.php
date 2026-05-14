<?php

declare(strict_types=1);

use App\Models\Admin;
use Filament\Panel;

it('can be created via factory', function () {
    $admin = Admin::factory()->create();

    expect($admin->id)->toBeInt()
        ->and($admin->email)->not->toBeEmpty()
        ->and($admin->name)->not->toBeEmpty();
});

it('always grants panel access', function () {
    $admin = Admin::factory()->create();

    expect($admin->canAccessPanel(Mockery::mock(Panel::class)))->toBeTrue();
});

it('hides password and remember_token in serialization', function () {
    $admin = Admin::factory()->create();
    $array = $admin->toArray();

    expect($array)
        ->not->toHaveKey('password')
        ->not->toHaveKey('remember_token');
});
