<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class ProjectCommit extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'commit_sha',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
