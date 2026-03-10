<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessStory extends Model
{
    /** @use HasFactory<\Database\Factories\SuccessStoryFactory> */
    use HasFactory;

    protected $guarded = [];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
