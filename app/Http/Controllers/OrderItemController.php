<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    // Get a list of all order items
    public function index()
    {
        return response()->json(OrderItem::all());
    }

    // Store a new order item
    public function store(Request $request)
    {
        $request->validate([
            'orderId' => 'required|integer|exists:orders,id',
            'productId' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $orderItem = OrderItem::create($request->all());

        return response()->json($orderItem, 201);
    }

    // Show a specific order item
    public function show($id)
    {
        return response()->json(OrderItem::findOrFail($id));
    }

    // Update a specific order item
    public function update(Request $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);

        $request->validate([
            'orderId' => 'sometimes|integer|exists:orders,id',
            'productId' => 'sometimes|integer|exists:products,id',
            'quantity' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
        ]);

        $orderItem->update($request->only(['orderId', 'productId', 'quantity', 'price']));

        return response()->json($orderItem);
    }

    // Delete a specific order item
    public function destroy($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->delete();

        return response()->json(null, 204);
    }
}