<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestResponse extends Model
{
    protected $fillable = ['test_session_id', 'question_id', 'answer_id', 'is_correct'];

    protected function casts(): array
    {
        return ['is_correct' => 'boolean'];
    }

    /** @return BelongsTo<TestSession, $this> */
    public function testSession(): BelongsTo
    {
        return $this->belongsTo(TestSession::class);
    }

    /** @return BelongsTo<Question, $this> */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /** @return BelongsTo<Answer, $this> */
    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}
