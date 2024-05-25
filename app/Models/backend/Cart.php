<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\Items;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
  // Use SoftDeletes;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $table = 'cart';
  protected $primaryKey = 'cart_id';
  protected $fillable = [
    'contact_id', 'item_id','quantity','paid_status'
  ];


  public function get_items(){
    return $this->hasMany(Items::class, 'item_id', 'item_id');
  }
  


}
