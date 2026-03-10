<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
        use HasFactory, Notifiable;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function managedProjects()
{
    return $this->hasMany(Project::class, 'project_manager_id');
}
public function scopeProjectManagers($query)
{
    return $query->where('position','project_manager');
}

public function managedPrograms()
{
    return $this->hasMany(Program::class, 'program_manager_id');
}
public function scopeProgramManagers($query)
{
    return $query->where('position','program_manager');
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