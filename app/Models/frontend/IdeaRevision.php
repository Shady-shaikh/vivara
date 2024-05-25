<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IdeaRevision extends Model
{
    use SoftDeletes;
    protected $table = 'idea_revision';
    protected $primaryKey = 'idea_revision_id';



    protected $fillable = ['idea_revision_id', 'idea_id', 'title', 'description', 'image_path', 'created_at', 'update_at', 'deleted_at',];
}
