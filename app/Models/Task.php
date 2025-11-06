<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'author_id',
        'assignee_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];

    public function product() {
        return $this->belongsTo(Project::class);
    }

    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function assignee() {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}
