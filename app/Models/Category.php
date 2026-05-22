<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CategoryFactory;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'description', 'icon', 'sort_order'])]
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    /** @var array<string, class-string> */
    protected $casts = [
        'icon' => Heroicon::class,
    ];

    /** @return array<int, string> */
    public static function validIconValues(): array
    {
        return collect(Heroicon::cases())
            ->filter(fn (Heroicon $case): bool => ! str_starts_with($case->value, 'o-')
                && file_exists(base_path("vendor/livewire/flux/stubs/resources/views/flux/icon/{$case->value}.blade.php")))
            ->map(fn (Heroicon $case): string => $case->value)
            ->values()
            ->all();
    }

    /** @return HasMany<Question, $this> */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /** @return HasMany<Question, $this> */
    public function activeQuestions(): HasMany
    {
        return $this->hasMany(Question::class)->where('is_active', true);
    }
}
