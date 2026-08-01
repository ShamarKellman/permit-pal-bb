<?php

declare(strict_types=1);

use App\Filament\Resources\QuestionResource\Pages\CreateQuestion;
use App\Filament\Resources\QuestionResource\Pages\EditQuestion;
use App\Filament\Resources\QuestionResource\Pages\ListQuestions;
use App\Models\Admin;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

beforeEach(fn () => $this->actingAs(Admin::factory()->create(), 'admin'));

it('can list questions', function () {
    $questions = Question::factory()->count(3)->create();
    livewire(ListQuestions::class)->assertCanSeeTableRecords($questions);
});

it('can create a question with answers', function () {
    $category = Category::factory()->create();

    livewire(CreateQuestion::class)
        ->fillForm([
            'category_id' => $category->id,
            'question_text' => 'What does a red light mean?',
            'difficulty' => 'easy',
            'is_active' => true,
            'answers' => [
                ['answer_text' => 'Stop',  'is_correct' => true,  'explanation' => 'Always stop at red.'],
                ['answer_text' => 'Go',    'is_correct' => false, 'explanation' => null],
                ['answer_text' => 'Slow',  'is_correct' => false, 'explanation' => null],
            ],
        ])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertRedirect();

    assertDatabaseHas(Question::class, ['question_text' => 'What does a red light mean?']);
    assertDatabaseHas(Answer::class, ['answer_text' => 'Stop', 'is_correct' => true]);
});

it('can toggle active status', function () {
    $question = Question::factory()->create(['is_active' => true]);
    Answer::factory()->count(2)->create(['question_id' => $question->id]);

    livewire(EditQuestion::class, ['record' => $question->id])
        ->fillForm(['is_active' => false])
        ->call('save')
        ->assertHasNoFormErrors();

    assertDatabaseHas(Question::class, ['id' => $question->id, 'is_active' => false]);
});

it('shows existing image on the edit form', function () {
    Storage::fake('public');
    Storage::disk('public')->put('signs/no-entry.png', 'fake-image-contents');

    $question = Question::factory()->create(['image_path' => 'signs/no-entry.png']);
    Answer::factory()->count(2)->create(['question_id' => $question->id]);

    $files = livewire(EditQuestion::class, ['record' => $question->id])
        ->get('data.image_path');

    expect(array_values($files))->toBe(['signs/no-entry.png']);
});
