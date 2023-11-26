<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieImage extends Model
{
    use HasFactory;

    public function categorie() {
        return $this->belongsTo(Categorie::class);
    }
}
