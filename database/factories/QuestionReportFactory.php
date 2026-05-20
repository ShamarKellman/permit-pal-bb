<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuestionReport>
 */
class QuestionReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'user_id' => null,
            'report_type' => fake()->randomElement(['wrong_answer', 'typo', 'unclear_question', 'other']),
            'description' => fake()->optional()->sentence(),
            'status' => 'pending',
            'resolved_at' => null,
        ];
    }

    public function resolved(): static
    {
        return $this->state([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);
    }
}
