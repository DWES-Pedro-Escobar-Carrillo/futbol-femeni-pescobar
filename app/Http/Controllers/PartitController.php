<?php

namespace App\Http\Controllers;

use App\Models\Partit;
use App\Models\Equip;
use App\Models\Estadi;
use App\Models\User; // Para obtener lista de árbitros si quieres asignarlos
use App\Services\PartitService;
use App\Http\Requests\StorePartitRequest;
use App\Http\Requests\UpdatePartitRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Events\PartitActualitzat;
use Illuminate\Http\Request;

class PartitController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private PartitService $servei) {}

    public function index()
    {
        $partits = $this->servei->llistar();
        return view('partits.index', compact('partits'));
    }

    public function show(Partit $partit)
    {
        return view('partits.show', compact('partit'));
    }

    public function create()
    {
        $this->authorize('create', Partit::class);

        $equips = Equip::all();
        $estadis = Estadi::all();
        // Opcional: pasar lista de árbitros
        $arbitres = User::where('role', 'arbitre')->get();

        return view('partits.create', compact('equips', 'estadis', 'arbitres'));
    }

    public function store(StorePartitRequest $request)
    {
        $this->authorize('create', Partit::class);
        
        $this->servei->guardar($request->validated());
        
        return redirect()->route('partits.index')->with('success', 'Partit creat.');
    }

    public function edit(Partit $partit)
    {
        $this->authorize('update', $partit);
        
        $equips = Equip::all();
        $estadis = Estadi::all();
        return view('partits.edit', compact('partit', 'equips', 'estadis'));
    }

    public function update(UpdatePartitRequest $request, Partit $partit)
    {
        $this->authorize('update', $partit);

        // Lógica: Si es Árbitro, SOLO recogemos los goles.
        if (Auth::user()->role === 'arbitre') {
            $data = $request->only(['gols_local', 'gols_visitant']);
        } else {
            // Si es Admin, recogemos todo
            $data = $request->validated();
        }

        PartitActualitzat::dispatch($partit->id);

        // Pasamos ID al servicio
        $this->servei->actualitzar($partit->id, $data);

        return redirect()->route('partits.index')->with('success', 'Partit actualitzat.');
    }

    public function destroy(Partit $partit)
    {
        $this->authorize('delete', $partit);
        $this->servei->eliminar($partit->id);
        return redirect()->route('partits.index')->with('success', 'Partit eliminat.');
    }

    public function historic()
    {
        return view('partits.historic');
    }
}