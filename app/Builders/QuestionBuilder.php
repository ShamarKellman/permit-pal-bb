<?php

declare(strict_types=1);

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<\App\Models\Question>
 */
class QuestionBuilder extends Builder
{
    public function active(): self
    {
        return $this->where('is_active', true);
    }
}
