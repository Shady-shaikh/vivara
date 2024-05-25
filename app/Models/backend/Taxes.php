<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\backend\Invoices;
use Illuminate\Database\Eloquent\SoftDeletes;

class Taxes extends Model
{
  use  SoftDeletes;
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $table = 'taxes';
  protected $primaryKey = 'id';
  protected $fillable = [
    'tax_id', 'tax_name', 'tax_percentage', 'tax_specification'
  ];


  


}
