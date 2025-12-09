<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipRequest;
use App\Http\Requests\UpdateEquipRequest;
use App\Models\Equip;
use App\Models\Estadi;
use App\Services\EquipService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EquipController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private EquipService $servei) {}

    public function index()
    {
        return view('equips.index', ['equips' => $this->servei->llistar()]);
    }

    public function create()
    {
        $this->authorize('create', Equip::class);
        $estadis = Estadi::all();
        return view('equips.create', compact('estadis'));
    }

    public function store(StoreEquipRequest $request)
    {
        // La autorización create se puede hacer aquí o en el Request
        $this->authorize('create', Equip::class);
        
        $this->servei->guardar($request->validated(), $request->file('escut'));
        return redirect()->route('equips.index')->with('success', 'Equip creat correctament!');
    }

    public function show(Equip $equip)
    {
        return view('equips.show', compact('equip'));
    }

    public function edit(Equip $equip)
    {
        $this->authorize('update', $equip);
        $estadis = Estadi::all();
        return view('equips.edit', compact('equip', 'estadis'));
    }

    public function update(UpdateEquipRequest $request, Equip $equip)
    {
        $this->authorize('update', $equip);
        
        $this->servei->actualitzar($equip->id, $request->validated(), $request->file('escut'));
        return redirect()->route('equips.index')->with('ok', 'Equip actualitzat');
    }

    public function destroy(Equip $equip)
    {
        $this->authorize('delete', $equip);
        $this->servei->eliminar($equip->id);
        return redirect()->route('equips.index');
    }
}