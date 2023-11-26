<?php

declare(strict_types=1);

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
        'onSite'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}