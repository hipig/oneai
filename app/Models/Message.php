<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    const TYPE_USER = 'user';
    const TYPE_ASSISTANT = 'assistant';
    const TYPE_NEW_CONTEXT = 'new_context';

    protected $fillable = [
        'chat_id',
        'type',
        'content'
    ];

    public function chat() : BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}
