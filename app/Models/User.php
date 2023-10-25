<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function password() : Attribute
    {
        return Attribute::set(function ($value) {
           return ['passoword' => Hash::make($value)];
        });
    }

    protected function avatar(): Attribute
    {
        return Attribute::get(function ($value) {
                if (Str::startsWith($value, ['http://', 'https://'])) {
                    return $value;
                }

                return \Avatar::create($this->attributes['name'])->toBase64();
            }
        );
    }
}
