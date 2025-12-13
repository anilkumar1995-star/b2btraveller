<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apilog extends Model
{
    protected $fillable = ['url', 'modal', 'txnid', 'header', 'request', 'response'];

    public function setHeaderAttribute($value)
    {
        $this->attributes['header'] = (json_encode($value));
    }

    public function setRequestAttribute($value)
    {
        $this->attributes['request'] = (json_encode($value));
    }

    public function setResponseAttribute($value)
    {
        $this->attributes['response'] = (json_encode($value));
    }

    public function getHeaderAttribute($value)
    {
        return ($value);
    }

    public function getRequestAttribute($value)
    {
        return ($value);
    }

    public function getResponseAttribute($value)
    {
        return ($value);
    }
}
