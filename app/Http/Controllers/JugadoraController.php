<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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

    public function index(Request $request)
    {
        $jugadores = $request->session()->get('jugadores', $this->getSeedData());
        if (!$request->session()->has('jugadores')) {
            $request->session()->put('jugadores', $jugadores);
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

        $jugadores = $request->session()->get('jugadores', []);

        $newJugadora = [
            'id' => count($jugadores) + 1,
            'nom' => $request->input('nom'),
            'equip' => $request->input('equip'),
            'posicio' => $request->input('posicio'),
        ];

        $jugadores[] = $newJugadora;
        $request->session()->put('jugadores', $jugadores);

        return redirect()->route('jugadores.index')
                        ->with('success', 'Jugadora creada correctament.');
    }
}