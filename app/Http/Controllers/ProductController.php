<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer',
            'price' => 'required|numeric'
        ]);

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:categories,id',
            'supplier_id' => 'sometimes|required|exists:suppliers,id',
            'quantity' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric'
        ]);

        $product->update($request->only(['name', 'category_id', 'supplier_id', 'quantity', 'price']));

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(null, 204);
    }
}