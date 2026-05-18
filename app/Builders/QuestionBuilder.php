<?php

declare(strict_types=1);

namespace App\Builders;

use App\Models\Question;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Question>
 */
class QuestionBuilder extends Builder
{
    public function active(): self
    {
        return $this->where('is_active', true);
    }

    public function forCategory(int $categoryId): self
    {
        return $this->where('category_id', $categoryId);
    }
}
