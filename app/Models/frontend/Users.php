<?php

namespace App\Models\frontend;

use App\Models\frontend\Ideas;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'last_name', 'country','state','email','contact_id' ,'company_name','contact_type','password', 'mobile_no', 'role','sub_role', 'created_at', 'update_at', 'deleted_at', 'location', 'department', 'active_status', 'company_id', 'designation_id', 'centralized_decentralized_type'];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
        // dd(bcrypt($password));
    }

    public function userrole()
    {
        return $this->hasOne(Role::class, 'id', 'role');
    }

    // Relations 
    public function ideas()
    {
        return $this->hasOne(Ideas::class, 'user_id', 'user_id');
    }

    public function user_notifications()
    {
        return $this->hasMany(Notification::class, 'receiver_id', 'user_id');
    }
}
