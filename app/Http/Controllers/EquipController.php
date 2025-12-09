<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipRequest;
use App\Http\Requests\UpdateEquipRequest;
use App\Models\Equip;
use App\Models\Estadi;
use App\Services\EquipService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Import necessari per a les polítiques

class EquipController extends Controller {
    
    use AuthorizesRequests; // Habilita l'ús de $this->authorize()

    public function __construct(private EquipService $servei) {}

    // GET /equips
    public function index() {
        // Opcional: Si vols filtrar qui pot veure la llista
        // $this->authorize('viewAny', Equip::class);
        return view('equips.index', ['equips' => $this->servei->llistar()]);
    }

    // GET /equips/create
    public function create() {
        // Opcional: Només admins poden crear
        $this->authorize('create', Equip::class); 
        
        $estadis = Estadi::all();
        return view('equips.create', compact('estadis'));
    }

    // POST /equips
    public function store(StoreEquipRequest $request) {
        // Opcional: Només admins poden guardar
        $this->authorize('create', Equip::class);

        $this->servei->guardar($request->validated());
        return redirect()->route('equips.index')->with('success', 'Equip creat correctament.');
    }

    // GET /equips/{id}
    public function show(Equip $equip) {
        // Tothom sol poder veure els detalls, però pots posar 'view' si cal
        $equip->load('jugadores', 'estadi', 'partitsLocal', 'partitsVisitant');
        return view('equips.show', compact('equip'));
    }

    // GET /equips/{id}/edit
    public function edit(Equip $equip) {
        // Comprova si l'usuari té permís per actualitzar aquest equip concret
        $this->authorize('update', $equip);

        $estadis = Estadi::all();
        return view('equips.edit', compact('equip', 'estadis'));
    }

    // PUT /equips/{id}
    public function update(UpdateEquipRequest $request, Equip $equip) {
        // Comprova si l'usuari té permís abans de fer res
        $this->authorize('update', $equip);

        $this->servei->actualitzar($equip->id, $request->validated());
        return redirect()->route('equips.index')->with('success', 'Equip actualitzat correctament.');
    }

    // DELETE /equips/{id}
    public function destroy(Equip $equip) {
        // Comprova si l'usuari té permís per eliminar (soles admin segons la guia)
        $this->authorize('delete', $equip);

        $this->servei->eliminar($equip->id);
        return redirect()->route('equips.index')->with('success', 'Equip eliminat correctament.');
    }
}