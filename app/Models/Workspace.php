<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workspace extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'owner_id'];


    // ------------------------------ RELATIONSHIPS ------------------------------
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    // ------------------------------ RELATIONSHIPS ------------------------------

}
