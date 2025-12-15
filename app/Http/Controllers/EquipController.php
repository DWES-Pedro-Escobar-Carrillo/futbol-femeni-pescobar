<?php

namespace App\Http\Controllers;

use App\Models\Equip;
use App\Models\Estadi; // <--- IMPORTANTE: Añadir esta línea
use App\Services\EquipService;
use App\Http\Requests\StoreEquipRequest;
use App\Http\Requests\UpdateEquipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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

    // --- CORRECCIÓN EN CREATE ---
    public function create()
    {
        $this->authorize('create', Equip::class);
        
        // Obtenemos los estadios para el select
        $estadis = Estadi::all(); 
        
        // Pasamos 'estadis' a la vista
        return view('equips.create', compact('estadis')); 
    }

    public function store(StoreEquipRequest $request)
    {
        $this->authorize('create', Equip::class);

        $data = $request->validated();
        $escut = $request->file('escut');

        $equip = $this->servei->guardar($data, $escut);

        if (Auth::user()->role === 'manager' && is_null(Auth::user()->team_id)) {
            $user = Auth::user();
            $user->team_id = $equip->id;
            if ($user instanceof \Illuminate\Database\Eloquent\Model) {
                $user->save();
            }
        }

        return redirect()->route('equips.index')->with('success', 'Equip creat correctament.');
    }

    // --- CORRECCIÓN EN EDIT ---
    public function edit(Equip $equip)
    {
        $this->authorize('update', $equip);

        // Obtenemos los estadios para el select
        $estadis = Estadi::all();

        // Pasamos 'equip' Y 'estadis' a la vista
        return view('equips.edit', compact('equip', 'estadis'));
    }

    public function update(UpdateEquipRequest $request, Equip $equip)
    {
        $this->authorize('update', $equip);

        $data = $request->validated();
        $escut = $request->file('escut');

        $this->servei->actualitzar($equip->id, $data, $escut);

        return redirect()->route('equips.index')->with('success', 'Equip actualitzat.');
    }

    public function destroy(Equip $equip)
    {
        $this->authorize('delete', $equip);
        $this->servei->eliminar($equip->id);
        
        return redirect()->route('equips.index')->with('success', 'Equip eliminat.');
    }
}