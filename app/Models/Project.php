<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    protected $guarded = [];

    public function projectManager()
{
    return $this->belongsTo(Employee::class, 'project_manager_id');
}
public function programs()
{
    return $this->hasMany(Program::class);
}

public function donors()
{
    return $this->belongsToMany(Donor::class, 'project_donor');
} 
public function grants()
{
    return $this->belongsToMany(Grant::class, 'grant_project', 'project_id', 'grant_id');

}
public function reports()
{
    return $this->hasMany(Report::class);
}
}