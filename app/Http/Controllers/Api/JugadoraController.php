<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jugadora;
use Illuminate\Http\Request;
use App\Http\Resources\JugadoraResource;
use App\Http\Resources\JugadoraCollection;

class JugadoraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new JugadoraCollection(Jugadora::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $jugadora = Jugadora::create($request->validated());
        return response()->json($jugadora, 201); // Recurs creat
    }

    /**
     * Display the specified resource.
     */
    public function show(Jugadora $jugadora)
    {
        return new JugadoraResource($jugadora);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jugadora $jugadora)
    {
        $jugadora->update($request->validated());
        return response()->json($jugadora, 200); // Actualització correcta
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jugadora $jugadora)
    {
        $jugadora->delete();
        return response()->noContent(); // 204 sense cos
    
    }
}
