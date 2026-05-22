<?php

declare(strict_types=1);

use App\Models\Category;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;

it('casts icon string to Heroicon enum on retrieval', function () {
    $category = Category::factory()->create(['icon' => 'shield-check']);

    expect($category->fresh()->icon)->toBe(Heroicon::ShieldCheck);
});

it('throws ValueError when an invalid icon is stored and the model is retrieved', function () {
    $id = DB::table('categories')->insertGetId([
        'name' => 'Test',
        'slug' => 'test-icon-invalid',
        'icon' => 'triangle-alert',
        'sort_order' => 99,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    expect(fn () => Category::query()->findOrFail($id)->icon)
        ->toThrow(ValueError::class);
});

it('returns null when icon is null', function () {
    $category = Category::factory()->create(['icon' => null]);

    expect($category->fresh()->icon)->toBeNull();
});
