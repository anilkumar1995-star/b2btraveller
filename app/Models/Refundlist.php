<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Refundlist extends Model
{
    protected $table = 'customer_refunds';

    protected $fillable = ['id','user_id', 'customer_id', 'amount','refund_date','remarks','status'];

    

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
