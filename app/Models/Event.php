<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'username',
        'ref',
        'ref_type',
        'action_name',
        'commit_to',
        'commit_title',
        'target_type',
        'target_title',
        'target_iid',
        'project_web_url',
        'project_name_with_namespace',
        'project_branch',
        'project_star_count',
        'project_forks_count',
        'last_activity_at',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
