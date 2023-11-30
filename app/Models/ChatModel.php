<?php

namespace App\Models;

class ChatModel extends Model
{
    protected $table = 'models';

    protected $fillable = [
        'group',
        'name',
        'rank',
        'status'
    ];
}
