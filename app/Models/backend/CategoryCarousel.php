<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class CategoryCarousel extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'categorycarousel';
    protected $primaryKey = 'product_car_id';
    protected $fillable = [
       'name','image', 'redirect_link'
    ];
}
