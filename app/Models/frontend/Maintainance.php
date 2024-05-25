<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maintainance extends Model
{

    protected $table = 'maintainance';
    protected $primaryKey = 'maintainance_id';
    protected $fillable = [
        'maintainance_id','user_id','customer_name','account_number',
        'maintainance_ifsc_code','branch_name','account_type','maintainance_name'//'order_id',//'Re_enter_account_number',
    ];

}
