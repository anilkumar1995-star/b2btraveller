<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Refundlist extends Model
{
    protected $table = 'customer_refunds';

    protected $fillable = ['id','user_id', 'customer_id', 'amount','remarks','status', 'account_number', 'ifsc_code', 'bank_name'];

    

    public $with = ['user', 'customer'];

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customerlist::class, 'customer_id', 'id');
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
