<?php

namespace App\Http\Controllers;

use App\Models\Estadi;
use App\Services\EstadiService;
use App\Http\Requests\StoreEstadiRequest;
use App\Http\Requests\UpdateEstadiRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EstadiController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private EstadiService $servei) {}

    public function index()
    {
        $estadis = $this->servei->llistar();
        return view('estadis.index', compact('estadis'));
    }

    public function show(Estadi $estadi)
    {
        return view('estadis.show', compact('estadi'));
    }

    public function create()
    {
        $this->authorize('create', Estadi::class);
        return view('estadis.create');
    }

    public function store(StoreEstadiRequest $request)
    {
        $this->authorize('create', Estadi::class);
        
        $this->servei->guardar($request->validated());
        
        return redirect()->route('estadis.index')->with('success', 'Estadi creat.');
    }

    public function edit(Estadi $estadi)
    {
        $this->authorize('update', $estadi);
        return view('estadis.edit', compact('estadi'));
    }

    public function update(UpdateEstadiRequest $request, Estadi $estadi)
    {
        $this->authorize('update', $estadi);
        
        // Pasamos ID
        $this->servei->actualitzar($estadi->id, $request->validated());
        
        return redirect()->route('estadis.index')->with('success', 'Estadi actualitzat.');
    }

    public function destroy(Estadi $estadi)
    {
        $this->authorize('delete', $estadi);
        
        // Pasamos ID
        $this->servei->eliminar($estadi->id);
        
        return redirect()->route('estadis.index')->with('success', 'Estadi eliminat.');
    }
}