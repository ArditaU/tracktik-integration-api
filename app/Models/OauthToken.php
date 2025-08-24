<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OauthToken extends Model
{
    protected $fillable = [
        'service',
        'refresh_token',
        'expires_at'
    ];
}
