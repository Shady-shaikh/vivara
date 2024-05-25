<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\backend\Items;

class PaymentInfo extends Model
{
  use SoftDeletes;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $table = 'payment_info';
  protected $primaryKey = 'id';
  protected $fillable = [
    'transaction_id', 'amount', 'payment_date', 'status', 'customer_name', 'item_id','invoice_id','payment_id',
    'email', 'data_dump', 'type', 'payment_tracking_code','customer_id','payment_mode'
  ];


  public function get_items()
  {
    // return $this->hasMany(Items::class,'item_id','item_id');
    $itemIds = explode(',', $this->item_id);
    return Items::whereIn('item_id', $itemIds)->get();
  }
}
