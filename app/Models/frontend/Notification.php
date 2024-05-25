<?php

namespace App\Models\frontend;

use App\Models\frontend\Ideas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'notification';
  protected $primaryKey = 'notification_id ';

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['notification_id', 'title','idea_uni_id', 'description', 'receiver_id', 'notification_read', 'created_at', 'updated_at', 'deleted_at'];

  // public function user_with_company()
  // {
  //     return $this->hasOne(Users::class, 'user_id', 'receiver_id')->where('company_id', Auth::user()->company_id);
  // }

}
