<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'config'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function messages() : HasMany
    {
        return $this->hasMany(Message::class, 'chat_id');
    }

    protected function config() : Attribute
    {
        return Attribute::make(
            function ($value) {
                return json_decode($value, true);
            },
            function ($value) {
                $configType = [
                    'model' => 'string',
                    'temperature' => 'float',
                    'top_p' => 'float',
                    'max_tokens' => 'number',
                    'presence_penalty' => 'float',
                    'frequency_penalty' => 'float',
                ];

                foreach ($configType as $key => $type) {
                    switch ($type) {
                        case 'string':
                            $value[$key] = (string)$value[$key];
                            break;
                        case 'number':
                            $value[$key] = (int)$value[$key];
                            break;
                        case 'float':
                            $value[$key] = (float)$value[$key];
                            break;
                    }
                }
                return ['config' => json_encode($value)];
            }
        );
    }
}
