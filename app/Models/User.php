<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    // use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['agentcode','name', 'email', 'mobile', 'password', 'remember_token', 'nsdlwallet', 'lockedamount', 'cclockedamount', 'aepslockedamount', 'role_id', 'parent_id', 'company_id', 'scheme_id', 'status', 'address', 'shopname', 'gstin', 'city', 'state', 'pincode', 'pancard', 'aadharcard', 'pancardpic', 'aadharcardpic', 'gstpic', 'profile', 'kyc', 'callbackurl', 'remark', 'resetpwd', 'otpverify', 'otpresend', 'account', 'bank', 'ifsc', 'bene_id1', 'apptoken', 'agntpic', 'signature', 'shop_photo', 'otpdate','livepic'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected static $logAttributes = ['id', 'name', 'email', 'mobile', 'password', 'scheme_id', 'status', 'address', 'shopname', 'gstin', 'city', 'state', 'pincode', 'pancard', 'aadharcard', 'callbackurl', 'otpverify', 'otpresend', 'account', 'bank', 'ifsc', 'apptoken','type'];

    protected static $logOnlyDirty = true;

    public $with = ['role', 'company'];
    protected $appends = ['parents', 'userbanks'];

    public function role()
    {

        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function getUserbanksAttribute()
    {
        // $user = UserBanks::where('user_id', $this->id)->where('status', 'active')->first();
        // return ['accountNo' => @$user->account_number, 'bankName' => @$user->bank_name, 'ifscCode' => @$user->ifsc, 'name' => @$user->name];

    }

    public function getParentsAttribute()
    {
        $user = User::where('id', $this->parent_id)->first(['id', 'name', 'mobile', 'role_id']);
        if ($user) {
            return $user->name . " (" . $user->id . ")<br>" . $user->mobile . "<br>" . $user->role->name;
        } else {
            return "Not Found";
        }
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d M y - h:i A', strtotime($value));
    }


    public static function createUserFromAndroid($post, $role)
    {
        // try {
        $isUserCreated = false;

        // DB::beginTransaction();

        $admin = self::whereHas('role', function ($q) {
            $q->where('slug', 'admin');
        })->first(['id', 'company_id']);

        $insertuser = $post->all();
        unset($insertuser['aadhaarcard']);
        unset($insertuser['slug']);
        $insertuser['role_id'] = $role->id;
        $insertuser['aadharcard'] = $post->aadhaarcard;
        // $insertuser['id'] = "new";
        $insertuser['parent_id'] = $admin->id;
        $insertuser['password'] = bcrypt($post->mobile);
        $insertuser['company_id'] = $admin->company_id;
        $insertuser['status'] = "pending";
        $insertuser['kyc'] = "pending";
        $insertuser['type'] = $post->type ?? "internal";
        unset($insertuser['meta']);

        // dd($insertuser);

        $isUserCreated = self::insertGetId($insertuser);

        // } catch (Exception $e) {
        //     DB::rollBack();
        //     $isUserCreated = false;

        // }

        return $isUserCreated;



    }

    public static function userDetailUpdate(string $whereKey, string $whereValue, array $data)
    {
        $isTableUpdate = false;
        if (!empty($whereKey) && !empty($whereValue)) {
            $table_name = self::where($whereKey, '=', $whereValue);
            $isTableUpdate = $table_name->update($data);
        }
        return (bool) $isTableUpdate;



    }

}
