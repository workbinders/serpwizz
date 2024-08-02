<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForgetPassword extends Model
{
    const EMAIL = 'email';
    const TOKEN = 'token';

    protected $fillable = [
        'EMAIL' => self::EMAIL,
        'TOKEN' => self::TOKEN,
    ];
}
