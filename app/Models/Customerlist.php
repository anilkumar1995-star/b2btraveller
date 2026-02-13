<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Customerlist extends Model
{
    protected $table = 'customer_list';

    protected $fillable = ['id', 'user_id', 'first_name', 'last_name', 'dob', 'address1', 'address2', 'address3', 'email', 'mobile', 'pan_number', 'passport_number', 'passport_expiry', 'gender', 'nationality',  'status'];

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
