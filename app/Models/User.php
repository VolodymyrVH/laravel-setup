<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function projects() {
        return $this->hasMany(Project::class, 'owner_id');
    }

    public function tasks() {
        return $this->hasMany(Task::class, 'author_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'author_id');
    }

    public function assignedProjects() {
        return $this->belongsToMany(Project::class, 'project_user')->withPivot('role');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
