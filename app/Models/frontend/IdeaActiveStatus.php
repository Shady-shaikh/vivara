<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaActiveStatus extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'idea_active_status';
    protected $primaryKey = 'idea_active_status_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idea_active_status_id', 'idea_active_status', 'created_at', 'update_at', 'deleted_at'];
}
