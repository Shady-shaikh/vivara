<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;

class ShippingDetails extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'shipping_details';
    protected $primaryKey = 'shipping_id';
    protected $fillable = ['shipping_id','invoice_id','shipping_status', 'order_tracking_no','remark','expected_delivery_date','delivery_date'];

    public function invoice(){
        return $this->belongsTo(Invoices::class,'invoice_id','invoice_id');
    }

}
