<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'manager_id',
        'name',
        'adress',
        'country',
        'city',
        'zip_code',
        'building',
        'verified',
        'verification_token',
    ];

    public function employee() {
        return $this->hasMany(Employee::class);
    }
}
