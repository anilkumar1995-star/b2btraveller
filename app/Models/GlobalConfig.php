<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class GlobalConfig extends Model
{
protected $table ='global_config';

protected $fillable = ['id','name','slug','attribute_1','attribute_2','attribute_3','attribute_4','attribute_5','type','status','is_active'];

 public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }
}

