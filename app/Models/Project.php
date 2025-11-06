<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
    ];
    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tasks() {
        return $this->belongsTo(Task::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'project_user')->withPivot('role');
    }
}
