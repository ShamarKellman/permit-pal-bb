<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question;
use App\Models\TestResponse;
use App\Models\TestSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TestResponse>
 */
class TestResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $question = Question::factory()->create();
        $answer = Answer::factory()->create(['question_id' => $question->id]);

        return [
            'test_session_id' => TestSession::factory(),
            'question_id' => $question->id,
            'answer_id' => $answer->id,
            'is_correct' => $answer->is_correct,
        ];
    }
}
