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
            'basket_id'  => $basket->id,
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);
    }

    public function update(Request $request) {

        $request->validate([
            'user_id'        => 'required',
            'basket_id'      => 'required',
            'basket_item_id' => 'required',
            'quantity'       => 'required',
        ]);

        $basket = Basket::find($request->basket_id)
            ->where('user_id', $request->user_id)
            ->where('status', 'active')
            ->first();

        $basketItem = BasketItem::find($request->basket_item_id)
            ->where('basket_id', $basket->id)
            ->toSql();


        $basketItem = BasketItem::where('basket_id', $basket->id)
            ->where('id', $request->basket_item_id)
            ->first();

        if($request->quantity < 1) {
            $basketItem->delete();
            return;
        }

        $basketItem->quantity = $request->quantity;
        $basketItem->save();
    }

    public function destroy(Request $request) {
        $request->validate([
            'user_id'        => 'required',
            'basket_id'      => 'required',
            'basket_item_id' => 'required',
        ]);

        $basket = Basket::find($request->basket_id)
            ->where('user_id', $request->user_id)
            ->where('status', 'active')
            ->first();

        $basketItem = BasketItem::where('basket_id', $basket->id)
            ->where('id', $request->basket_item_id)
            ->first();

        $basketItem->delete();
    }
}