<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;

    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function grant()
    {
        return $this->belongsTo(Grant::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
