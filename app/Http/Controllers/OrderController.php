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
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'status' => 'required|string'
        ]);

        $order = Order::create($request->all());

        return response()->json($order, 201);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'total_price' => 'sometimes|required|numeric',
            'status' => 'sometimes|required|string'
        ]);

        $order->update($request->only(['total_price', 'status']));

        return response()->json($order);
    }

    // Show a specific order
    public function show($id)
    {
        return response()->json(Order::findOrFail($id));
    }

    // Update a specific order
   

    // Delete a specific order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(null, 204);
    }
}
