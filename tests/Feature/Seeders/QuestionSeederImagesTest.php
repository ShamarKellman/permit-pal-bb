<?php

declare(strict_types=1);

use App\Models\Question;
use Database\Seeders\CategorySeeder;
use Database\Seeders\QuestionSeeder;
use Illuminate\Support\Facades\Storage;

it('publishes sign images to the public disk and maps them to questions', function () {
    Storage::fake('public');

    $this->seed([CategorySeeder::class, QuestionSeeder::class]);

    Storage::disk('public')->assertExists('signs/no-entry.svg');

    $question = Question::query()
        ->where('question_text', 'What does a red circular road sign with a white horizontal bar in the middle mean?')
        ->firstOrFail();

    expect($question->image_path)->toBe('signs/no-entry.svg');
});

it('has a published file for every seeded image path', function () {
    Storage::fake('public');

    $this->seed([CategorySeeder::class, QuestionSeeder::class]);

    $paths = Question::query()->whereNotNull('image_path')->pluck('image_path');

    expect($paths)->not->toBeEmpty();

    $paths->each(fn (string $path) => Storage::disk('public')->assertExists($path));
});
