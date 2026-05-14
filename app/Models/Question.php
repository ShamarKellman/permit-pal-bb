<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\QuestionBuilder;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[UseEloquentBuilder(QuestionBuilder::class)]
class Question extends Model
{
    protected $fillable = ['category_id', 'question_text', 'image_path', 'difficulty', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    /** @return BelongsTo<Category, $this> */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /** @return HasMany<Answer, $this> */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
