<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ChatSetting extends Settings
{
    public string $model;
    public static function group(): string
    {
        return 'chat';
    }
}
