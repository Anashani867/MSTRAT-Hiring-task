<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
   $orders = Order::with(['customer', 'product'])->paginate(10);
        return response()->json($orders);    }

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
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'total_amount' => 'required|numeric',
            'currency' => 'required|string',
            'server_datetime' => 'nullable|date',
            'datetime_utc' => 'nullable|date',
        ]);

        $order = Order::create($request->all());

        return response()->json(['message' => 'Order created successfully', 'data' => $order]);
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
    $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'product_id' => 'required|exists:products,id',
        'total_amount' => 'required|numeric',
        'currency' => 'required|string',
        'server_datetime' => 'nullable|date',
        'datetime_utc' => 'nullable|date',
    ]);

    $order->update($request->all());

    return response()->json(['message' => 'Order updated successfully', 'data' => $order]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
       $ids = $request->input('ids');

        if (!$ids || !is_array($ids)) {
            return response()->json(['message' => 'No order IDs provided or invalid format'], 400);
        }

        Order::whereIn('id', $ids)->delete();

        return response()->json(['message' => 'Orders deleted successfully']);
    }
}
