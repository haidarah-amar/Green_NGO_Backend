<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyFactory> */
    use HasFactory;

    protected $guarded = [];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'beneficial_id');
    }
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
