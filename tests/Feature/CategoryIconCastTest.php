<?php

declare(strict_types=1);

use App\Models\Category;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;

it('casts icon string to Heroicon enum on retrieval', function () {
    $category = Category::factory()->create(['icon' => 'shield-check']);

    expect($category->fresh()->icon)->toBe(Heroicon::ShieldCheck);
});

it('throws ValueError when an invalid icon is stored and the icon attribute is accessed', function () {
    // Insert raw invalid value directly to bypass enum cast on write
    DB::table('categories')->insert([
        'name' => 'Invalid Icon Category',
        'slug' => 'invalid-icon-category',
        'icon' => 'triangle-alert',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    expect(function () {
        Category::query()->latest('id')->first()->icon; // @phpstan-ignore-line
    })->toThrow(ValueError::class);
});
