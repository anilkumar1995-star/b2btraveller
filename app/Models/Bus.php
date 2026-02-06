<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Bus extends Model
{

    protected $table = 'bus_bookings';

    protected $fillable = [
        'id',
        'event',
        'user_id',
    ];


    public $with = ['user'];

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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
