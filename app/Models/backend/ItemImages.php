<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\backend\Invoices;
use App\Models\backend\Items;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemImages extends Model
{
  use SoftDeletes;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $table = 'item_images';
  protected $primaryKey = 'image_id';
  protected $fillable = [
    'group_id','item_id', 'image_name'
  ];



  // public function get_items()
  // {
  //   return $this->hasOne(Items::class, 'group_id', 'group_id');
  // }
}
