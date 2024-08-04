<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Order::all());
    }

    // Store a new order
    public function store(Request $request)
    {
        $request->validate([
            'customerId' => 'required|integer|exists:customers,id',
            'userId' => 'required|integer|exists:users,id',
            'totalPrice' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $order = Order::create($request->all());

        return response()->json($order, 201);
    }

    // Show a specific order
    public function show($id)
    {
        return response()->json(Order::findOrFail($id));
    }

    // Update a specific order
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'customerId' => 'sometimes|integer|exists:customers,id',
            'userId' => 'sometimes|integer|exists:users,id',
            'totalPrice' => 'sometimes|numeric',
            'status' => 'sometimes|string',
        ]);

        $order->update($request->only(['customerId', 'userId', 'totalPrice', 'status']));

        return response()->json($order);
    }

    // Delete a specific order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(null, 204);
    }
}
