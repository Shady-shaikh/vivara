<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaStatus extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'idea_status';
    protected $primaryKey = 'idea_status_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idea_status_id', 'idea_status', 'user_role', 'idea_id ', 'user_id', 'created_at', 'update_at', 'deleted_at'];
}
