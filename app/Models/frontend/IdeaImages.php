<?php

namespace App\Models\frontend;

use App\Models\frontend\Ideas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IdeaImages extends Model
{
  /**
   * The database table used by the model.
   *
   * @var string
   */
  protected $table = 'idea_images';
  protected $primaryKey = 'image_id ';

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['image_id', 'file_name', 'idea_uni_id', 'image_path', 'image_link', 'created_at', 'updated_at', 'deleted_at'];
  public function idea()
  {
    return $this->belongsTo(Ideas::class, 'idea_uni_id');
  }
}
