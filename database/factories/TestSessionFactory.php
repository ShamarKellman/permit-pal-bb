<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\TestSession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TestSession>
 */
class TestSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $score = fake()->numberBetween(0, 20);

        return [
            'user_id' => User::factory(),
            'session_token' => null,
            'started_at' => now()->subMinutes(fake()->numberBetween(5, 30)),
            'completed_at' => now(),
            'score' => $score,
            'total_questions' => 20,
            'passed' => $score >= 15,
        ];
    }

    public function guest(): static
    {
        return $this->state([
            'user_id' => null,
            'session_token' => Str::uuid()->toString(),
        ]);
    }

    public function incomplete(): static
    {
        return $this->state(['completed_at' => null, 'passed' => false]);
    }

    public function passed(): static
    {
        return $this->state(['score' => 17, 'passed' => true]);
    }

    public function failed(): static
    {
        return $this->state(['score' => 8, 'passed' => false]);
    }
}
