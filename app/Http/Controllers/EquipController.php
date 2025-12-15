<?php

namespace App\Http\Controllers;

use App\Models\Equip;
use App\Services\EquipService;
use App\Http\Requests\StoreEquipRequest;
use App\Http\Requests\UpdateEquipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Necesario para las Policies

class EquipController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private EquipService $servei) {}

    public function index()
    {
        $equips = $this->servei->llistar();
        return view('equips.index', compact('equips'));
    }

    public function show(Equip $equip)
    {
        return view('equips.show', compact('equip'));
    }

    public function create()
    {
        $this->authorize('create', Equip::class);
        return view('equips.create');
    }

    public function store(StoreEquipRequest $request)
    {
        $this->authorize('create', Equip::class);

        // 1. Obtenemos datos validados
        $data = $request->validated();
        
        // 2. Extraemos el archivo si existe (tu Servicio lo pide por separado)
        $escut = $request->file('escut');

        // 3. Llamamos al servicio
        $equip = $this->servei->guardar($data, $escut);

        // 4. Asignar equipo al manager si es necesario
        if (Auth::user()->role === 'manager' && is_null(Auth::user()->team_id)) {
            $user = Auth::user();
            $user->team_id = $equip->id;
            if ($user instanceof \Illuminate\Database\Eloquent\Model) {
                $user->save();
            } else {
                throw new \RuntimeException('The $user object is not a valid Eloquent model.');
            }
        }

        return redirect()->route('equips.index')->with('success', 'Equip creat correctament.');
    }

    public function edit(Equip $equip)
    {
        $this->authorize('update', $equip);
        return view('equips.edit', compact('equip'));
    }

    public function update(UpdateEquipRequest $request, Equip $equip)
    {
        $this->authorize('update', $equip);

        $data = $request->validated();
        $escut = $request->file('escut');

        // IMPORTANTE: Pasamos el ID ($equip->id), no el objeto entero, porque tu servicio pide "int $id"
        $this->servei->actualitzar($equip->id, $data, $escut);

        return redirect()->route('equips.index')->with('success', 'Equip actualitzat.');
    }

    public function destroy(Equip $equip)
    {
        $this->authorize('delete', $equip);
        
        // Pasamos el ID
        $this->servei->eliminar($equip->id);
        
        return redirect()->route('equips.index')->with('success', 'Equip eliminat.');
    }
}