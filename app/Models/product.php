<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function productImages() {
        return $this->hasMany(ProductImage::class);
    }

    public function discountLabel() {
        return $this->hasMany(DiscountLabel::class);
    }
}
