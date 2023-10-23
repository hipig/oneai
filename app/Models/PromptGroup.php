<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\HasMany;

class PromptGroup extends Model
{
    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 2;

    protected $fillable = [
        'name',
        'status',
    ];

    public function prompts() : HasMany
    {
        return $this->hasMany(Prompt::class, 'group_id');
    }
}
