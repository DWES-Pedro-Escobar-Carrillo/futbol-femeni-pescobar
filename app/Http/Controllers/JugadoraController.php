<?php

namespace App\Http\Controllers;

use App\Models\Jugadora;
use App\Models\Equip;
use App\Services\JugadoraService;
use App\Http\Requests\StoreJugadoraRequest;
use App\Http\Requests\UpdateJugadoraRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class JugadoraController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private JugadoraService $servei) {}

    public function index()
    {
        $jugadores = $this->servei->llistar();
        return view('jugadores.index', compact('jugadores'));
    }

    public function show(Jugadora $jugadora)
    {
        return view('jugadores.show', compact('jugadora'));
    }

    public function create()
    {
        $this->authorize('create', Jugadora::class);

        // Si es manager, solo le pasamos su equipo
        if (Auth::user()->role === 'manager') {
            $equips = Equip::where('id', Auth::user()->team_id)->get();
        } else {
            $equips = Equip::all();
        }
        
        // Asumimos opciones estáticas para el ejemplo, o podrías traerlas de un enum
        $posicions = ['Portera', 'Defensa', 'Migcampista', 'Davantera'];
        
        return view('jugadores.create', compact('equips', 'posicions'));
    }

    public function store(StoreJugadoraRequest $request)
    {
        $this->authorize('create', Jugadora::class);
        
        $data = $request->validated();

        // Seguridad extra: Si es manager, forzar el equip_id
        if (Auth::user()->role === 'manager') {
            $data['equip_id'] = Auth::user()->team_id;
        }

        $this->servei->guardar($data);

        return redirect()->route('jugadores.index')->with('success', 'Jugadora creada.');
    }

    public function edit(Jugadora $jugadora)
    {
        $this->authorize('update', $jugadora);

        if (Auth::user()->role === 'manager') {
            $equips = Equip::where('id', Auth::user()->team_id)->get();
        } else {
            $equips = Equip::all();
        }

        $posicions = ['Portera', 'Defensa', 'Migcampista', 'Davantera'];
        return view('jugadores.edit', compact('jugadora', 'equips', 'posicions'));
    }

    public function update(UpdateJugadoraRequest $request, Jugadora $jugadora)
    {
        $this->authorize('update', $jugadora);
        
        // El manager no debería poder cambiar la jugadora de equipo a uno que no sea el suyo
        // (ya cubierto por la lógica del form, pero el validated manda)
        $this->servei->actualitzar($jugadora, $request->validated());
        
        return redirect()->route('jugadores.index')->with('success', 'Jugadora actualitzada.');
    }

    public function destroy(Jugadora $jugadora)
{
    $this->authorize('delete', $jugadora);
    
    $this->servei->eliminar($jugadora->id); 
    
    return redirect()->route('jugadores.index')->with('success', 'Jugadora eliminada.');
}
}