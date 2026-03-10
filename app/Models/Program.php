<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    /** @use HasFactory<\Database\Factories\ProgramFactory> */
    use HasFactory;


    protected $guarded = [];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function beneficiaries()
    {
        return $this->belongsToMany(Beneficiary::class, 'program_beneficiary');
    }
    public function employees()
    {
        return $this->belongsTo(Employee::class, 'program_manager_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }


    public function expenses()
    {
        return $this->hasMany(Expenses::class);
    }


    public function successStories()
    {
        return $this->hasMany(SuccessStory::class);
    }












public static function programTypes()
{
    return [
        'economic_empowerment' => 'تمكين اقتصادي',
        'vocational_training' => 'تدريب مهني',
        'psychosocial_support' => 'دعم نفسي',
        'agricultural_development' => 'تنمية زراعية',
        'community_leadership' => 'قيادة مجتمعية',
        'entrepreneurship' => 'ريادة أعمال',
    ];
}
}
