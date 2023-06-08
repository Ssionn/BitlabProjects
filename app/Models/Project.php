<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'path',
        'web_url',
        'ssh_url_to_repo',
        'star_count',
        'forks_count',
        'last_activity_at',
    ];

    public function commits()
    {
        return $this->hasMany(ProjectCommit::class);
    }

    public function branches()
    {
        return $this->hasMany(ProjectBranches::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
