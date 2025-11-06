<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session; // AFEGIT

class EstadiController extends Controller
{
    /**
     * Dades inicials per a la sessió.
     */
    private function getSeedData()
    {
        return [
            [
                'id' => 1,
                'nom' => 'Estadi Johan Cruyff',
                'ciutat' => 'Sant Joan Despí',
                'capacitat' => 6000,
                'equip_principal' => 'FC Barcelona Femení',
            ],
            [
                'id' => 2,
                'nom' => 'Centro Deportivo Wanda Alcalá de Henares',
                'ciutat' => 'Alcalá de Henares',
                'capacitat' => 2800,
                'equip_principal' => 'Atlètic de Madrid Femení',
            ],
            [
                'id' => 3,
                'nom' => 'Estadio Alfredo Di Stéfano',
                'ciutat' => 'Madrid',
                'capacitat' => 6000,
                'equip_principal' => 'Real Madrid Femení',
            ],
        ];
    }

    /**
     * Mostra el llistat d'estadis.
     */
    public function index() // CANVIAT: Treure Request $request
    {
        // Carrega les dades de la sessió o les dades inicials si no existeixen
        $estadis = Session::get('estadis', $this->getSeedData()); // CANVIAT: Usar Session

        // Assegura que les dades inicials es guarden a la sessió la primera vegada
        if (!Session::has('estadis')) { // CANVIAT: Usar Session
            Session::put('estadis', $estadis); // CANVIAT: Usar Session
        }

        return view('estadis.index', compact('estadis'));
    }

    /**
     * Mostra el formulari per crear un nou estadi.
     */
    public function create()
    {
        return view('estadis.create');
    }

    /**
     * Emmagatzema el nou estadi a la sessió.
     */
    public function store(Request $request)
    {
        // Validació dels camps
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|min:3',
            'ciutat' => 'required|string|min:2',
            'capacitat' => 'required|integer|min:0',
            'equip_principal' => 'required|string|min:3',
        ]);

        // Si la validació falla, torna al formulari amb els errors
        if ($validator->fails()) {
            return redirect()->route('estadis.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        // Aconsegueix les dades actuals de la sessió
        $estadis = Session::get('estadis', []); // CANVIAT: Usar Session

        // Crea el nou estadi
        $newEstadi = [
            // Assigna un ID simple (basat en el comptador + 1)
            'id' => count($estadis) + 1, 
            'nom' => $request->input('nom'),
            'ciutat' => $request->input('ciutat'),
            'capacitat' => $request->input('capacitat'),
            'equip_principal' => $request->input('equip_principal'),
        ];

        // Afegeix el nou estadi a l'array
        $estadis[] = $newEstadi;

        // Guarda el nou array a la sessió
        Session::put('estadis', $estadis); // CANVIAT: Usar Session

        // Redirigeix al llistat amb un missatge d'èxit
        return redirect()->route('estadis.index')
                        ->with('success', 'Estadi creat correctament.');
    }

    /**
     * Mostra un estadi específic.
     */
    public function show(int $id) // AFEGIT
    {
        $estadis = Session::get('estadis', $this->getSeedData());

        // L'ID rebut és la *clau* de l'array, com a EquipController
        abort_if(!isset($estadis[$id]), 404, 'Estadi no trobat');
        
        $estadi = $estadis[$id];
        
        return view('estadis.show', compact('estadi'));
    }
}