<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // validate request
        $request->validate([
            'company_id' => 'required|integer',
        ]);

        // get all orders from the last week
        $ordersLastWeek = Order::where('company_id', $request->company_id)
            ->where('created_at', '>=', now()->subWeek())
            // ->where('status', 'paid')
            ->get();

        $orderDays = [];

        // loop through the orders and push the day and total price to the array
        foreach ($ordersLastWeek as $order) {
            array_push($orderDays, [
                'day' => $order->created_at->format('l'),
                'total_price' => $order->total_price,
            ]);
        }

        return response()->json([
            'orderDays' => $orderDays,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getAdminOrders(Request $request) {
        // validate request
        $request->validate([
            'user_id' => 'required',
        ]);

        // check if user exists
        $user = User::where('id', $request->user_id)->first();

        // check if user is super admin
        if(!$user) {
            return response('user not found', 404);
        }

        // check if user is super admin
        if(!$user->role == 'super_admin') {
            return response('unauthorized', 401);
        }

        // get all orders
        $orders = Order::with('company')->get();

        return response()->json($orders);
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
        // validate request
        $request->validate([
            'token' => 'required|string',
        ]);

        // get the user and basket
        $user = User::with('basket')->where('id', $request->token)->first();
        $basket = $user->basket->where('status', 'active')->first();
        $order = Order::where('basket_id', $basket->id)->first();

        return response()->json($order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
