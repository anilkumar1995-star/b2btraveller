<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PortalSetting extends Model
{
	// use LogsActivity;
    protected $fillable = ['name', 'code', 'value'];

    protected static $logAttributes = ['name', 'code', 'value'];
    protected static $logOnlyDirty = true;
    
    public $timestamps = false;

    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }
}
