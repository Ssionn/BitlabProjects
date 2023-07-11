<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProjectCommit;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function commits(): HasMany
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
