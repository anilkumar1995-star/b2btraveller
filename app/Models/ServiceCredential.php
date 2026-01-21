<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCredential extends Model
{
    protected $table = 'service_credentials';

    protected $fillable = [
        'name',
        'client_id',
        'client_secret',
        'auth_url',
        'search_url',
        'code',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
