<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Basket;
use App\Models\BasketItem;
use App\Models\Product;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required',
            'product_id' => 'required'
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = User::find($request->user_id);

        if($user->has_active_basket) {
            $user_basket = $user->basket()->where('status', 'active')->first();

            (new BasketItemController())->create($user_basket, $product);

            $basketItems = BasketItem::where('basket_id', $user_basket->id)
                ->with('product')
                ->get();

            $totalPrice = 0;

            foreach($basketItems as $item) {
                $totalPrice += ($item->quantity * (float)$item->product->price);
            }

            $user_basket->total_price = $totalPrice;

            $user_basket->save();

            return response()->json($user_basket, 200);
        }

        $basket = Basket::create([
            'user_id' => $request->user_id,
            'status' => 'active',
            'total_price' => $product->price,
        ]);

        $user->has_active_basket = true;

        $user->save();

        (new BasketItemController)->create($basket, $product);

        return $basket;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $basket = Basket::where('user_id', $request->user_id)
            ->where('status', 'active')
            ->with('basketItems.product.productImages')
            ->first();

        return $basket;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Basket $basket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Basket $basket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Basket $basket)
    {
        //
    }
}
