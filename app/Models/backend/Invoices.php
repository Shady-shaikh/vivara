<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\backend\Items;
use App\Models\frontend\Users;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
  use  SoftDeletes;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $table = 'invoices';
  protected $primaryKey = 'id';
  protected $fillable = [
    'invoice_number', 'customer_id', 'item_id', 'date','discount',
    'due_date', 'rate', 'quantity', 'invoice_id', 'total', 'balance', 'current_sub_status'
  ];



  // public function item_data()
  // {
  //     return $this->hasOne(Items::class,'item_id','item_id');
  // }

  public function item_data()
  {
    $itemIds = explode(',', $this->item_id);
    return Items::whereIn('item_id', $itemIds)->get();
  }
  public function customer_data()
  {
    return $this->hasOne(Users::class, 'contact_id', 'customer_id');
  }

  public function shippingDetails(){
    return $this->hasOne(ShippingDetails::class,'invoice_id','invoice_id');
  }
}
