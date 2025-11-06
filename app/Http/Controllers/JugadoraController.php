<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session; // AFEGIT

class JugadoraController extends Controller
{
    private function getSeedData()
    {
        return [
            ['id' => 1, 'nom' => 'Alexia Putellas', 'equip' => 'Barça Femení', 'posicio' => 'Migcampista'],
            ['id' => 2, 'nom' => 'Esther González', 'equip' => 'Atlètic de Madrid', 'posicio' => 'Davantera'],
            ['id' => 3, 'nom' => 'Misa Rodríguez', 'equip' => 'Real Madrid Femení', 'posicio' => 'Portera'],
        ];
    }

    public function index() // CANVIAT: Treure Request $request
    {
        $jugadores = Session::get('jugadores', $this->getSeedData()); // CANVIAT: Usar Session
        if (!Session::has('jugadores')) { // CANVIAT: Usar Session
            Session::put('jugadores', $jugadores); // CANVIAT: Usar Session
        }
        return view('jugadores.index', compact('jugadores'));
    }

    public function create()
    {
        // Definim les posicions per al <select>
        $posicions = ['Portera', 'Defensa', 'Migcampista', 'Davantera'];
        return view('jugadores.create', compact('posicions'));
    }

    public function store(Request $request)
    {
        $posicionsValides = ['Portera', 'Defensa', 'Migcampista', 'Davantera'];

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|min:3',
            'equip' => 'required|string|min:2',
            'posicio' => ['required', Rule::in($posicionsValides)],
        ]);

        if ($validator->fails()) {
            return redirect()->route('jugadores.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $jugadores = Session::get('jugadores', []); // CANVIAT: Usar Session

        $newJugadora = [
            'id' => count($jugadores) + 1,
            'nom' => $request->input('nom'),
            'equip' => $request->input('equip'),
            'posicio' => $request->input('posicio'),
        ];

        $jugadores[] = $newJugadora;
        Session::put('jugadores', $jugadores); // CANVIAT: Usar Session

        return redirect()->route('jugadores.index')
                        ->with('success', 'Jugadora creada correctament.');
    }

    /**
     * Mostra una jugadora específica.
     */
    public function show(int $id) // AFEGIT
    {
        $jugadores = Session::get('jugadores', $this->getSeedData());

        // L'ID rebut és la *clau* de l'array, com a EquipController
        abort_if(!isset($jugadores[$id]), 404, 'Jugadora no trobada');
        
        $jugadora = $jugadores[$id];
        
        return view('jugadores.show', compact('jugadora'));
    }
}