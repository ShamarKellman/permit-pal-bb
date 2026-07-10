<?php

declare(strict_types=1);

use App\Livewire\Study\FlashCard;
use App\Models\Category;
use App\Models\Question;

use function Pest\Livewire\livewire;

it('renders the first question', function () {
    $category = Category::factory()->create();
    $question = Question::factory()->create(['category_id' => $category->id]);

    livewire(FlashCard::class, ['categorySlug' => $category->slug])
        ->assertSee($question->question_text);
});

it('advances to next question', function () {
    $category = Category::factory()->create();
    Question::factory()->count(3)->create(['category_id' => $category->id]);

    livewire(FlashCard::class, ['categorySlug' => $category->slug])
        ->assertSet('currentIndex', 0)
        ->call('next')
        ->assertSet('currentIndex', 1);
});

it('goes back to previous question', function () {
    $category = Category::factory()->create();
    Question::factory()->count(3)->create(['category_id' => $category->id]);

    livewire(FlashCard::class, ['categorySlug' => $category->slug])
        ->call('next')
        ->call('previous')
        ->assertSet('currentIndex', 0);
});

it('does not go below index zero', function () {
    $category = Category::factory()->create();
    Question::factory()->create(['category_id' => $category->id]);

    livewire(FlashCard::class, ['categorySlug' => $category->slug])
        ->call('previous')
        ->assertSet('currentIndex', 0);
});

it('toggles isFlipped on flip call', function () {
    $category = Category::factory()->create();
    Question::factory()->create(['category_id' => $category->id]);

    livewire(FlashCard::class, ['categorySlug' => $category->slug])
        ->assertSet('isFlipped', false)
        ->call('flip')
        ->assertSet('isFlipped', true);
});

it('resets flip when navigating to next', function () {
    $category = Category::factory()->create();
    Question::factory()->count(2)->create(['category_id' => $category->id]);

    livewire(FlashCard::class, ['categorySlug' => $category->slug])
        ->call('flip')
        ->assertSet('isFlipped', true)
        ->call('next')
        ->assertSet('isFlipped', false);
});

it('shows the sign image on the card front when present', function () {
    $category = Category::factory()->create();
    Question::factory()->create([
        'category_id' => $category->id,
        'image_path' => 'signs/no-entry.svg',
    ]);

    livewire(FlashCard::class, ['categorySlug' => $category->slug])
        ->assertSeeHtml('signs/no-entry.svg');
});
