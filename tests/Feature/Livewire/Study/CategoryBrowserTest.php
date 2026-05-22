<?php

declare(strict_types=1);

use App\Livewire\Study\CategoryBrowser;
use App\Models\Category;
use App\Models\Question;
use Database\Seeders\CategorySeeder;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Cache;

use function Pest\Livewire\livewire;

it('renders all categories', function () {
    $categories = Category::factory()->count(3)->create();
    livewire(CategoryBrowser::class)
        ->assertSee($categories->first()->name)
        ->assertSee($categories->last()->name);
});

it('shows active question count per category', function () {
    $category = Category::factory()->create();
    Question::factory()->count(5)->create(['category_id' => $category->id, 'is_active' => true]);
    Question::factory()->inactive()->create(['category_id' => $category->id]);

    livewire(CategoryBrowser::class)->assertSee('5');
});

it('orders categories by sort_order', function () {
    Category::factory()->create(['name' => 'Zebra Topic', 'sort_order' => 2]);
    Category::factory()->create(['name' => 'Alpha Topic', 'sort_order' => 1]);

    $html = livewire(CategoryBrowser::class)->html();
    expect(mb_strpos($html, 'Alpha Topic'))->toBeLessThan(mb_strpos($html, 'Zebra Topic'));
});

it('renders without error when categories use seeder icon names', function () {
    Cache::flush();
    (new CategorySeeder)->run();

    livewire(CategoryBrowser::class)->assertOk();
});

it('renders without error for each individual seeder-defined icon', function (string $icon) {
    Cache::flush();
    Category::factory()->create(['icon' => $icon]);

    livewire(CategoryBrowser::class)->assertOk();
})->with([
    Heroicon::ExclamationTriangle->value,
    Heroicon::Signal->value,
    Heroicon::Bolt->value,
    Heroicon::ArrowRightCircle->value,
    Heroicon::ArrowsRightLeft->value,
    Heroicon::Map->value,
    Heroicon::ShieldCheck->value,
    Heroicon::User->value,
    Heroicon::AcademicCap->value,
    Heroicon::LightBulb->value,
    Heroicon::Truck->value,
    Heroicon::Tag->value,
]);
