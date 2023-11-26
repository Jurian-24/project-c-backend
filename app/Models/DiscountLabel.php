<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountLabel extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
