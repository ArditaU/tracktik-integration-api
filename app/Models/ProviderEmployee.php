<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderEmployee extends Model
{
    protected $fillable = [
        'provider_name',
        'provider_employee_id',
        'tracktik_employee_id'
    ];
}
