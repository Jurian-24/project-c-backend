<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'company_id' => 'required|integer',
        ]);

        $ordersLastWeek = Order::where('company_id', $request->company_id)
            ->where('created_at', '>=', now()->subWeek())
            // ->where('status', 'paid')
            ->get();

        $orderDays = [];

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
    public function show(Order $order)
    {
        //
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
