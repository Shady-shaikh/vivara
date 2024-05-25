<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use App\Models\backend\Items;

class ProductCarousel extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'productcarousel';
    protected $primaryKey = 'product_car_id';
    protected $fillable = [
       'name','image', 'redirect_link'
    ];

    public function get_item(){
        return $this->hasOne(Items::class,'item_id','name');
    }
}
