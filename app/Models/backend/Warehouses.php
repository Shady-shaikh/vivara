<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\backend\Invoices;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouses extends Model
{
  Use SoftDeletes;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $table = 'warehouses';
  protected $primaryKey = 'id';
  protected $fillable = [
    'warehouse_id', 'item_id','warehouse_name', 'warehouse_stock_on_hand', 'initial_stock', 'initial_stock_rate',
    'warehouse_available_stock','warehouse_actual_available_stock',
    'warehouse_available_for_sale_stock','warehouse_actual_available_for_sale_stock'
  ];


  public function get_item(){
    return $this->hasOne(Items::class,'item_id','item_id');
  }
  


}
