<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(2, true),
            'slug' => fake()->unique()->slug(2),
            'description' => fake()->sentence(),
            'icon' => fake()->randomElement(
                collect(Heroicon::cases())
                    ->filter(fn (Heroicon $case): bool => ! str_starts_with($case->value, 'o-')
                        && file_exists(base_path("vendor/livewire/flux/stubs/resources/views/flux/icon/{$case->value}.blade.php")))
                    ->map(fn (Heroicon $case): string => $case->value)
                    ->all()
            ),
            'sort_order' => fake()->numberBetween(1, 99),
        ];
    }
}
