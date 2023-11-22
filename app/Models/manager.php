<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'start_date'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}
