<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'answer_text' => fake()->sentence(),
            'is_correct' => false,
            'explanation' => fake()->optional()->sentence(),
        ];
    }

    public function correct(): static
    {
        return $this->state(['is_correct' => true]);
    }
}
