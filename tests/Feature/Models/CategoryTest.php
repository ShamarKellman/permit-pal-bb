<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Question;

it('can be created with factory', function () {
    $category = Category::factory()->create();
    expect($category->name)->toBeString();
    expect($category->slug)->toBeString();
});

it('has many questions', function () {
    $category = Category::factory()->create();
    Question::factory()->count(3)->create(['category_id' => $category->id]);
    expect($category->load('questions')->questions)->toHaveCount(3);
});

it('active questions excludes inactive', function () {
    $category = Category::factory()->create();
    Question::factory()->create(['category_id' => $category->id, 'is_active' => true]);
    Question::factory()->inactive()->create(['category_id' => $category->id]);
    expect($category->load('activeQuestions')->activeQuestions)->toHaveCount(1);
});
