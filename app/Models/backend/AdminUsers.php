<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Permission\Models\Role;

class AdminUsers extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_users';
    protected $primaryKey = 'admin_user_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['admin_user_id','token','centralized_decentralized_type', 'first_name', 'last_name', 'email', 'password', 'mobile_no', 'profile_pic', 'role_id', 'account_status', 'remember_token', 'location', 'company_id', 'location_id', 'designation_id', 'department', 'is_admin', 'user_type', 'role', 'status', 'account_status'];
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
        // dd(bcrypt($password));
    }

    public function userrole()
    {
        return $this->hasOne(Role::class, 'id', 'role');
    }
}
