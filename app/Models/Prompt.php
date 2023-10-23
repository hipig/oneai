<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prompt extends Model
{
    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 2;
    protected $fillable = [
        'group_id',
        'name',
        'content',
        'status',
    ];

    public function group() : BelongsTo
    {
        return $this->belongsTo(PromptGroup::class, 'group_id');
    }
}
