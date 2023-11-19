<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;

    public function productImages() {
        return $this->hasMany(ProductImage::class);
    }

    public function discountLabel() {
        return $this->hasMany(DiscountLabel::class);
    }
}
