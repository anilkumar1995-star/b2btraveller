<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pindata extends Model
{
	protected $fillable = ['pin','user_id'];

	public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }
}
