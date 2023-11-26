<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_id',
        'joined_at'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function manager() {
        return $this->hasOne(Manager::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function attendance() {
        return $this->hasMany(Attendance::class);
    }
}
