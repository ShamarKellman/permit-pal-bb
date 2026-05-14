<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'sort_order'];

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
