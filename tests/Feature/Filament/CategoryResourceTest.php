<?php

declare(strict_types=1);

use App\Filament\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\CategoryResource\Pages\ListCategories;
use App\Models\Category;
use App\Models\User;

use function Pest\Livewire\livewire;

beforeEach(fn () => $this->actingAs(User::factory()->create()));

it('can list categories', function () {
    $categories = Category::factory()->count(3)->create();
    livewire(ListCategories::class)->assertCanSeeTableRecords($categories);
});

it('can create a category', function () {
    livewire(CreateCategory::class)
        ->fillForm(['name' => 'Road Markings', 'slug' => 'road-markings', 'sort_order' => 13])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertRedirect();

    Pest\Laravel\assertDatabaseHas(Category::class, ['slug' => 'road-markings']);
});

it('requires name and slug', function () {
    livewire(CreateCategory::class)
        ->fillForm(['name' => null, 'slug' => null])
        ->call('create')
        ->assertHasFormErrors(['name' => 'required', 'slug' => 'required']);
});

it('can edit a category', function () {
    $category = Category::factory()->create();
    livewire(EditCategory::class, ['record' => $category->id])
        ->fillForm(['name' => 'Updated Name'])
        ->call('save')
        ->assertHasNoFormErrors();

    Pest\Laravel\assertDatabaseHas(Category::class, ['id' => $category->id, 'name' => 'Updated Name']);
});
