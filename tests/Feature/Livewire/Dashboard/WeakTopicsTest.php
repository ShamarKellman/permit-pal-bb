<?php

declare(strict_types=1);

use App\Livewire\Dashboard\WeakTopics;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\TestResponse;
use App\Models\TestSession;
use App\Models\User;

use function Pest\Livewire\livewire;

it('shows categories where the user scored below 70 percent', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create(['name' => 'Speed Limits']);
    $question = Question::factory()->create(['category_id' => $category->id]);
    $answer = Answer::factory()->create(['question_id' => $question->id, 'is_correct' => false]);
    $session = TestSession::factory()->create(['user_id' => $user->id]);
    TestResponse::factory()->create([
        'test_session_id' => $session->id,
        'question_id' => $question->id,
        'answer_id' => $answer->id,
        'is_correct' => false,
    ]);

    $this->actingAs($user);

    livewire(WeakTopics::class)->assertSee('Speed Limits');
});
