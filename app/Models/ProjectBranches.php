<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class ProjectBranches extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'branch',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
