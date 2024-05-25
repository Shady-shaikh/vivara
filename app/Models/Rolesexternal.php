<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Rolesexternal extends Model
{
  //use Sluggable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles_external';
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'role_type', 'role_name','status_values','menu_values','button_values'
    ];

    // use SoftDeletes;
    // protected $dates = ['deleted_at'];
    // public function sluggable()
    // {
    //     return [
    //         'category_slug' => [
    //             'source' => 'category_name',
    //             'onUpdate'=>true
    //         ]
    //     ];
    // }

}
