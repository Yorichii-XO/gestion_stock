<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return response()->json(Inventory::all());
    }

    public function show($id)
    {
        return Inventory::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'current_stock' => 'required|integer',
            'product_id' => 'required|exists:products,id',
        ]);

        $inventory = Inventory::create($validated);
        return response()->json($inventory, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'location' => 'sometimes|required|string|max:255',
            'capacity' => 'sometimes|required|integer',
            'current_stock' => 'sometimes|required|integer',
            'product_id' => 'sometimes|required|exists:products,id',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update($validated);
        return response()->json($inventory, 200);
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();
        return response()->json(null, 204);
    }
}