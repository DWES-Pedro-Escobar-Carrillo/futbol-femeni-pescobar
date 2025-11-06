<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session; // AFEGIT

class PartitController extends Controller
{
    private function getSeedData()
    {
        return [
            ['id' => 1, 'local' => 'Barça Femení', 'visitant' => 'Atlètic de Madrid', 'data' => '2024-11-30', 'resultat' => null],
            ['id' => 2, 'local' => 'Real Madrid Femení', 'visitant' => 'Barça Femení', 'data' => '2024-12-15', 'resultat' => '0-3'],
        ];
    }

    public function index() // CANVIAT: Treure Request $request
    {
        $partits = Session::get('partits', $this->getSeedData()); // CANVIAT: Usar Session
        if (!Session::has('partits')) { // CANVIAT: Usar Session
            Session::put('partits', $partits); // CANVIAT: Usar Session
        }
        return view('partits.index', compact('partits'));
    }

    public function create()
    {
        return view('partits.create');
    }

    public function store(Request $request)
    {
        // Definim les regles de validació
        $rules = [
            'local' => 'required|string|min:2',
            'visitant' => 'required|string|min:2|different:local',
            'data' => 'required|date_format:Y-m-d',
            'resultat' => 'nullable|regex:/^\d+-\d+$/',
        ];

        // Definim missatges personalitzats
        $messages = [
            'visitant.different' => 'L\'equip visitant ha de ser diferent de l\'equip local.',
            'resultat.regex' => 'El format del resultat ha de ser N-N (ex. 2-1).',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('partits.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $partits = Session::get('partits', []); // CANVIAT: Usar Session

        $newPartit = [
            'id' => count($partits) + 1,
            'local' => $request->input('local'),
            'visitant' => $request->input('visitant'),
            'data' => $request->input('data'),
            'resultat' => $request->input('resultat'), // Serà null si està buit
        ];

        $partits[] = $newPartit;
        Session::put('partits', $partits); // CANVIAT: Usar Session

        return redirect()->route('partits.index')
                        ->with('success', 'Partit creat correctament.');
    }

    /**
     * Mostra un partit específic.
     */
    public function show(int $id) // AFEGIT
    {
        $partits = Session::get('partits', $this->getSeedData());

        // L'ID rebut és la *clau* de l'array, com a EquipController
        abort_if(!isset($partits[$id]), 404, 'Partit no trobat');
        
        $partit = $partits[$id];
        
        return view('partits.show', compact('partit'));
    }
}