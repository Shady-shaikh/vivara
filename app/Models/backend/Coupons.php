<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Coupons extends Model
{
  use Sluggable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'coupons';
     protected $primaryKey = 'coupon_id';
     protected $fillable = [
       'coupon_code','coupon_title', 'coupon_title','value','coupon_type',
       'start_date','end_date','status','coupon_purchase_limit','coupon_usage_limit','coupon_once_per_user','copoun_desc'
     ];

     public function sluggable():array
     {
         return [
             'cms_slug' => [
                 'source' => 'cms_pages_title'
             ]
         ];
     }

}
