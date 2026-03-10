<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    /** @use HasFactory<\Database\Factories\GrantFactory> */
    use HasFactory;

    protected $guarded = [];

    public function project()
    {
        return $this->belongsToMany(Project::class, 'grant_project', 'grant_id', 'project_id');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expenses::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

}
