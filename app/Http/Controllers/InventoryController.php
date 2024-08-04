<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Get a list of all inventories
    public function index()
    {
        return response()->json(Inventory::with('products')->get());
    }

    // Store a new inventory
    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'currentStock' => 'required|integer',
        ]);

        $inventory = Inventory::create($request->all());

        return response()->json($inventory, 201);
    }

    // Show a specific inventory
    public function show($id)
    {
        return response()->json(Inventory::with('products')->findOrFail($id));
    }

    // Update a specific inventory
    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $request->validate([
            'location' => 'sometimes|string|max:255',
            'capacity' => 'sometimes|integer',
            'currentStock' => 'sometimes|integer',
        ]);

        $inventory->update($request->only(['location', 'capacity', 'currentStock']));

        return response()->json($inventory);
    }

    // Delete a specific inventory
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return response()->json(null, 204);
    }
}