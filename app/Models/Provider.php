<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Provider extends Model
{
    // use LogsActivity;

    protected $table = "billpay_providers"; 
    protected $fillable = ['name', 'recharge1', 'recharge2', 'api_id', 'type', 'status', 'paramcount', 'manditcount', 'paramname', 'maxlength', 'minlength', 'regex', 'fieldtype', 'ismandatory'];

    public $timestamps = false;

    public function getParamnameAttribute($value)
    {
        return explode(",", $value);
    }

    public function getMaxlengthAttribute($value)
    {
        return explode(",", $value);
    }

    public function getMinlengthAttribute($value)
    {
        return explode(",", $value);
    }

    public function getRegexAttribute($value)
    {
        return explode(",", $value);
    }

    public function getIsmandatoryAttribute($value)
    {
        return explode(",", $value);
    }

    public function getFieldtypeAttribute($value)
    {
        return explode(",", $value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    protected static $logAttributes = ['name', 'recharge1', 'recharge2', 'api_id', 'type', 'status'];
    protected static $logOnlyDirty = true;

    public function api()
    {
        return $this->belongsTo('App\Models\Api');
    }
}
