<?php

declare(strict_types=1);

use App\Filament\Resources\QuestionResource\Pages\CreateQuestion;
use App\Filament\Resources\QuestionResource\Pages\EditQuestion;
use App\Filament\Resources\QuestionResource\Pages\ListQuestions;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\User;

use function Pest\Livewire\livewire;

beforeEach(fn () => $this->actingAs(User::factory()->create()));

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

    Pest\Laravel\assertDatabaseHas(Question::class, ['question_text' => 'What does a red light mean?']);
    Pest\Laravel\assertDatabaseHas(Answer::class, ['answer_text' => 'Stop', 'is_correct' => true]);
});

it('can toggle active status', function () {
    $question = Question::factory()->create(['is_active' => true]);
    Answer::factory()->count(2)->create(['question_id' => $question->id]);

    livewire(EditQuestion::class, ['record' => $question->id])
        ->fillForm(['is_active' => false])
        ->call('save')
        ->assertHasNoFormErrors();

    Pest\Laravel\assertDatabaseHas(Question::class, ['id' => $question->id, 'is_active' => false]);
});
