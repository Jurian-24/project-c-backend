<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'week_number',
        'week_day',
        'year',
        'on_site',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
