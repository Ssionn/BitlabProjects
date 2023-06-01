<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectCommit;
use App\Models\ProjectBranches;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'project_id',
    ];

    public function commits()
    {
        return $this->hasMany(ProjectCommit::class);
    }

    public function branches()
    {
        return $this->hasMany(ProjectBranches::class);
    }
}
