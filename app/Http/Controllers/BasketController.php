<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Basket;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\OrderLine;
use App\Models\BasketItem;
use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;

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
            'user_id'     => $request->user_id,
            'status'      => 'active',
            'total_price' => $product->price,
        ]);

        $user->has_active_basket = true;
        $user->save();

        (new BasketItemController)->create($basket, $product);

        return $basket;
    }

    public function checkout(Request $request) {
        $request->validate([
            'user_id' => 'required',
        ]);

        // $user = User::find($request->user_id)->with('employee.company')->first();

        $user = User::where('id', $request->user_id)
            ->with('employee.company')
            ->first();

        $basket = Basket::where('user_id', $request->user_id)
            ->where('status', 'active')
            ->with('basketItems.product')
            ->first();

        $totalPrice = 0;

        foreach($basket->basketItems as $item) {
            $totalPrice += ($item->quantity * $item->product->price);
        }

        $totalPrice = number_format($totalPrice, 2);

        $invoice = Invoice::create([
            'user_id'  => $user->id,
            'order_id' => null,
        ]);

        $order = Order::create([
            'basket_id'        => $basket->id,
            'invoice_id'       => $invoice->id,
            'total_price'      => $totalPrice,
            'status'           => 'pending',
            'payment_method'   => 'IDEAL',
            'payment_status'   => 'pending',
            'company_id'       => $user->employee->company->id,
            'delivery_service' => 'Albert Heijn',
        ]);

        $invoice->order_id = $order->id;
        $invoice->save();

        foreach($basket->basketItems as $item) {
            $orderLine = OrderLine::create([
                'order_id'   => $order->id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
                'product_id' => $item->product->id,
                'price'      => round($item->quantity * $item->product->price, 2),
            ]);
        }

        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value"    => $order->total_price,
            ],
            "description" => "Buurtboer Bestelling: {$order->id}",
            "redirectUrl" => env("APP_URL") . "/api/finish-payment",
            "method"      => "ideal",
            "metadata"    => [
                "order_id" => "{$order->id}",
            ],
        ]);

        Mollie::api()->payments->update($payment->id, [
            "redirectUrl" => "http://localhost:8000/api/finish-payment/{$payment->id}",
        ]);

        // return redirect($payment->getCheckoutUrl(), 303);

        return response()->json([
            'payment' => $payment->getCheckoutUrl(),
            'order'   => $order,
        ], 200);
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

    public function finishPayment($id) {
        // return Mollie::api()->payments->get('tr_'. $id);
        $payment = Mollie::api()->payments->get($id);

        $order = Order::find($payment->metadata->order_id);

        if($payment->isPaid()) {
            $order->payment_status = 'PAID';
            $order->status = 'PROCESSING';
            $order->save();

            $basket = Basket::find($order->basket_id);
            $basket->status = 'inactive';
            $basket->save();

            $invoice = Invoice::find($order->invoice_id);
            $user = User::find($invoice->user_id);
            $user->has_active_basket = false;
            $user->save();

            return redirect(env('FRONTEND_URL').'/payment-status?status=success');
        }

        return redirect(env('FRONTEND_URL').'/payment-status?status=failed');
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
