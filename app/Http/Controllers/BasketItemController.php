<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use Illuminate\Http\Request;

class BasketItemController extends Controller
{
    public function create(Basket $basket, Product $product) {
        $existingItem = $basket->basketItems()->where('product_id', $product->id)->first();

        if($existingItem) {
            $existingItem->quantity += 1;
            $existingItem->save();

            return;
        }

        BasketItem::create([
            'basket_id' => $basket->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }
}
