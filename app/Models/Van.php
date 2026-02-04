<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Van extends Model
{
    protected $table = 'user_van_accounts';

    protected $fillable = ['id','user_id', 'root_type','account_holder_name','vpa_address','account_number', 'ifsc'];

    

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
