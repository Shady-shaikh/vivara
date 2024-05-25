<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\backend\Invoices;
use App\Models\backend\Schemes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Items extends Model
{
  use SoftDeletes;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $table = 'items';
  protected $primaryKey = 'id';
  protected $fillable = [
    'item_id','group_id','group_name', 'group_data','name', 'item_type', 'product_type', 'rate', 'hsn_or_sac','sku', 'tax_specification', 'offer','category','variant','size','item_image',
    'intra_tax_percent', 'inter_tax_percent', 'unit', 'stock_on_hand', 'available_stock', 'description'
  ];

  public function warehouses()
  {
    return $this->hasMany(Warehouses::class, 'item_id', 'item_id');
  }

  public function get_offers()
  {
    return $this->hasOne(Schemes::class, 'schemes_id', 'offer');
  }

  public function get_group(){
    return $this->hasOne(ItemImages::class, 'group_id', 'group_id');

  }
}
