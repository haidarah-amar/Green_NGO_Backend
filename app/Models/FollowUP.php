<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
     /** @use HasFactory<\Database\Factories\FollowUPFactory> */
    use HasFactory;

    protected $guarded = [];
    protected $table = 'follow_u_p_s';

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'mel_officer_id');
    }

}
