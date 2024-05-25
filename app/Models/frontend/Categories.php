<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Categories extends Model
{
  use Sluggable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';
    protected $primaryKey = 'category_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id','category_name', 'category_description','category_banner_image','visibility','has_subcategories'];

    // use SoftDeletes;
    // protected $dates = ['deleted_at'];
    public function sluggable()
    {
        return [
            'category_slug' => [
                'source' => 'category_name'
            ]
        ];
    }

    public function subcategories()
    {
      return $this->hasMany(SubCategories::class,'category_id','category_id');
    }

}
