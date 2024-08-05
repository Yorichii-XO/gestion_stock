<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Client::all());
    }

    public function show($id)
    {
        return Client::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $client = Client::create($validated);
        return response()->json($client, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255|unique:clients,email,' . $id,
            'phone' => 'sometimes|required|string|max:20',
            'address' => 'sometimes|required|string|max:255',
        ]);

        $client = Client::findOrFail($id);
        $client->update($validated);
        return response()->json($client, 200);
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return response()->json(null, 204);
    }
}