<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Beneficiary extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'program_beneficiary');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_beneficiaries', 'beneficiary_id', 'activity_id');
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    public function successStories()
    {
        return $this->hasMany(SuccessStory::class);
    }
}
