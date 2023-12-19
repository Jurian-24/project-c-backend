<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable=[
        'order_id',
        'user_id',
        'company_id',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'delivery_service',
    ];

    public function order()
    {
        $this->belongsTo(Order::class);
    }

    public function user()
    {
        $this->BelongsTo(User::class);
    }
}
