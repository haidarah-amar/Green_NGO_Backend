<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /** @use HasFactory<\Database\Factories\ActivityFactory> */
    use HasFactory;

    protected $guarded = [];

    public function beneficiaries()
    {
        return $this->belongsToMany(User::class, 'activity_beneficiaries', 'activity_id', 'beneficiary_id');
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }
}
