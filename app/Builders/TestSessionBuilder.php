<?php

declare(strict_types=1);

namespace App\Builders;

use App\Models\TestSession;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<TestSession>
 */
class TestSessionBuilder extends Builder
{
    public function completed(): self
    {
        return $this->whereNotNull('completed_at');
    }

    public function today(): self
    {
        return $this->whereDate('started_at', today());
    }
}
