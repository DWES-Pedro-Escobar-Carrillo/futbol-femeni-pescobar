<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartitController extends Controller
{
    private function getSeedData()
    {
        return [
            ['id' => 1, 'local' => 'Barça Femení', 'visitant' => 'Atlètic de Madrid', 'data' => '2024-11-30', 'resultat' => null],
            ['id' => 2, 'local' => 'Real Madrid Femení', 'visitant' => 'Barça Femení', 'data' => '2024-12-15', 'resultat' => '0-3'],
        ];
    }

    public function index(Request $request)
    {
        $partits = $request->session()->get('partits', $this->getSeedData());
        if (!$request->session()->has('partits')) {
            $request->session()->put('partits', $partits);
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

        $partits = $request->session()->get('partits', []);

        $newPartit = [
            'id' => count($partits) + 1,
            'local' => $request->input('local'),
            'visitant' => $request->input('visitant'),
            'data' => $request->input('data'),
            'resultat' => $request->input('resultat'), // Serà null si està buit
        ];

        $partits[] = $newPartit;
        $request->session()->put('partits', $partits);

        return redirect()->route('partits.index')
                        ->with('success', 'Partit creat correctament.');
    }
}