<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use Illuminate\Http\Request;

class BasketItemController extends Controller
{
    public function create(Basket $basket, Product $product) {
        // check if the product already exits in the basket
        $existingItem = $basket->basketItems()->where('product_id', $product->id)->first();

        // if so increase the quantity by 1
        if($existingItem) {
            $existingItem->quantity += 1;
            $existingItem->save();

            return;
        }

        // if not create a new basket item
        BasketItem::create([
            'basket_id'  => $basket->id,
            'product_id' => $product->id,
            'quantity'   => 1,
        ]);
    }

    public function update(Request $request) {

        // validate request
        $request->validate([
            'user_id'        => 'required',
            'basket_id'      => 'required',
            'basket_item_id' => 'required',
            'quantity'       => 'required',
        ]);

        // find the basket
        $basket = Basket::find($request->basket_id)
            ->where('user_id', $request->user_id)
            ->where('status', 'active')
            ->first();

        // find the basket item
        $basketItem = BasketItem::find($request->basket_item_id)
            ->where('basket_id', $basket->id)
            ->toSql();

        // update the quantity
        $basketItem = BasketItem::where('basket_id', $basket->id)
            ->where('id', $request->basket_item_id)
            ->first();

        // if the quantity is 0 or less, delete the basket item
        if($request->quantity < 1) {
            $basketItem->delete();
            return;
        }

        // save the new quantity
        $basketItem->quantity = $request->quantity;
        $basketItem->save();
    }

    public function destroy(Request $request) {
        // validate request
        $request->validate([
            'user_id'        => 'required',
            'basket_id'      => 'required',
            'basket_item_id' => 'required',
        ]);

        // find the basket
        $basket = Basket::find($request->basket_id)
            ->where('user_id', $request->user_id)
            ->where('status', 'active')
            ->first();

        // find the basket item
        $basketItem = BasketItem::where('basket_id', $basket->id)
            ->where('id', $request->basket_item_id)
            ->first();

        // delete the basket item
        $basketItem->delete();
    }
}
