<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Customerlist extends Model
{
    protected $table = 'customer_list';

    protected $fillable = ['id','user_id', 'name','email','mobile','account_number','address','bank_name','address','status', 'ifsc_code'];

    

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
