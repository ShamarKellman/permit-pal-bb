<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\TestSessionBuilder;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

#[UseEloquentBuilder(TestSessionBuilder::class)]
class TestSession extends Model
{
    /** @use HasFactory<\Database\Factories\TestSessionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 'session_token', 'started_at',
        'completed_at', 'score', 'total_questions', 'passed',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'passed' => 'boolean',
        ];
    }

    public static function recentPassRate(int $days = 30): int
    {
        return Cache::remember("pass_rate_{$days}", 600, function () use ($days) {
            $cutoff = now()->subDays($days);

            $total = static::completed()
                ->where('started_at', '>=', $cutoff)
                ->count();

            if ($total === 0) {
                return 0;
            }

            $passed = static::completed()
                ->where('started_at', '>=', $cutoff)
                ->where('passed', true)
                ->count();

            return (int) round(($passed / $total) * 100);
        });
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return HasMany<TestResponse, $this> */
    public function responses(): HasMany
    {
        return $this->hasMany(TestResponse::class);
    }
}
