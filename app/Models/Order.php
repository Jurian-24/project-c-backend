<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable=[
        'basket_id',
        'invoice_id',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'company_id',
        'delivery_service'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function orderLines()
    {
        return $this->hasMany(OrderLine::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
