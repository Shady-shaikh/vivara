<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissingPayments extends Model
{
  Use SoftDeletes;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $table = 'missing_payments';
  protected $primaryKey = 'payment_id';
  protected $fillable = [
    'user_id', 'transaction_id', 'amount', 'payment_date', 'status','customer_name',
    'email', 'data_dump', 'type', 'payu_response'
  ];


  


}
