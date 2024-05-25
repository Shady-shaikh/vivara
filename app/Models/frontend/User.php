<?php

namespace App\Models\frontend;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','provider','provider_id', 'email', 'password','mobile_no','last_name','dob',
        'address','profile_pic','adhaar_no','welcome_email','pan',
        'alt_mobile_no','gender','otp','account_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Add a mutator to ensure hashed passwords
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public static function getUsersDeatails($sdate,$edate)
    {
        $users = DB::table('users')->select('name', 'email', 'mobile_no', 'created_at')->whereBetween('created_at', [$sdate, $edate])
            ->get()->toArray();
        return $users;
    }
}
