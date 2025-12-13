<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apitoken extends Model
{
    protected $fillable = ['token', 'ip', 'user_id', 'domain'];

    public function setDomainAttribute($value)
    {
        $this->attributes['domain'] = str_replace("https://", '', str_replace("http://", '', str_replace("www.", '', $value)));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }
}
