<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
    protected $table = "agents";
    protected $fillable = ['bc_id','bbps_agent_id','bbps_id', 'bc_f_name', 
    'bc_m_name', 'bc_l_name', 'emailid', 'phone1', 'phone2', 'bc_dob', 
    'bc_state', 'bc_district', 'bc_address', 'bc_block', 'bc_city', 'bc_landmark',
     'bc_loc', 'bc_mohhalla', 'bc_pan', 'bc_pincode', 'shopname', 'shopType', 
     'qualification', 'population', 'locationType', 'status', 'udf1','user_id'];
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public $appends = ['username'];
    
    public function getUsernameAttribute()
    {
        $data = '';
        if($this->user_id){
            $user = \App\User::where('id' , $this->user_id)->first(['name', 'id', 'role_id']);
            $data = $user->name." (".$user->id.") <br>(".$user->role->name.")";
        }
        return $data;
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
