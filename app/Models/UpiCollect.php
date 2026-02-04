<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UpiCollect extends Model
{

    protected $table = 'fund_recieved_callback';

    protected $fillable = [
        'id',
        'event',
        'user_id',
        'fund_id',
        'remitter_full_name',
        'remitter_account_number',
        'remitter_ifsc',
        'remitter_phone_number',
        'utr',
        'payment_mode',
        'amount',
        'narration',
        'status',
        'transaction_date',
        'virtual_account_id',
        'label',
        'virtual_account_number',
        'virtual_ifsc_number',
        'fee',
        'tax',
        'margin',
        'created_at',
        'updated_at',
        'project_id'
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
