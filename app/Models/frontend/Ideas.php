<?php

namespace App\Models\frontend;

use App\Models\frontend\Users;
use App\Models\frontend\IdeaImages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ideas extends Model
{
    use SoftDeletes;
    protected $table = 'ideas';
    protected $primaryKey = 'idea_id';


    protected $fillable = ['idea_id', 'user_id', 'idea_uni_id', 'title', 'description', 'image_path', 'category_id', 'created_at', 'update_at', 'deleted_at', 'reject_reason', 'resubmit_reason', 'implemented', 'approving_authority_approval', 'assessment_team_approval', 'active_status', 'certificate'];

    // Relations 
    public function user()
    {
        return $this->hasOne(Users::class, 'user_id', 'user_id');
    }
    public function user_with_company()
    {
        return $this->hasOne(Users::class, 'user_id', 'user_id')->where('company_id', Auth::user()->company_id);
    }
    public function images()
    {
        return $this->hasMany(IdeaImages::class, 'idea_uni_id');
    }
}
