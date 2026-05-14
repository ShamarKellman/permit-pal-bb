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
}
