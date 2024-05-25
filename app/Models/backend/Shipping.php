<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $table = 'shipping_method';
     protected $primaryKey = 'shipping_method_id';
    protected $fillable = ['shipping_method_status','shipping_method_id','shipping_method_name', 'shipping_method_code','shipping_method_cost'];

}
