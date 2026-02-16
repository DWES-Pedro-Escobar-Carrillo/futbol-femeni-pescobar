<?php

namespace App\Http\Controllers;

use App\Models\Equip;
use App\Models\Estadi;
use App\Services\EquipService;
use App\Http\Requests\StoreEquipRequest;
use App\Http\Requests\UpdateEquipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// Imports per a la IA
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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
        // --- INTEGRACIÓ DEFINITIVA AMB GEMINI 2.5 ---
        
        // Guardem la resposta en cache durant 24h per estalviar crides (i diners/quota)
        // Per forçar una nova descripció: php artisan cache:clear
        $descripcio_ia = Cache::remember('descripcio_equip_' . $equip->id, 86400, function () use ($equip) {
            
            $apiKey = env('GEMINI_API_KEY');
            
            if (!$apiKey) {
                return "Falta configurar GEMINI_API_KEY al fitxer .env";
            }

            // Prompt millorat per a la IA
            $prompt = "Escriu una descripció breu (màxim 60 paraules), èpica i professional per a l'equip de futbol femení '{$equip->nom}'. 
                       Juga a l'estadi '{$equip->estadi->nom}'. Destaca el seu estil de joc ofensiu i la passió de l'afició.";

            // --- MODEL ACTUALITZAT A GEMINI 2.5 FLASH ---
            // Utilitzem el model que hem vist a la teva llista: 'gemini-2.5-flash'
            $model = 'gemini-2.5-flash';
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ]
            ]);

            // Si la resposta és correcta (Codi 200)
            if ($response->successful()) {
                // Extreiem el text de la resposta JSON
                return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'La IA no ha retornat cap text.';
            }

            // --- GESTIÓ D'ERRORS ---
            // Si falla, guardem l'error al log per no embrutar la pantalla de l'usuari final
            Log::error('Gemini API Error: ' . $response->body());
            
            // Retornem un missatge d'error visible (pots canviar-ho per un text buit si prefereixes)
            return 'No s\'ha pogut generar la descripció en aquest moment.';
        });

        return view('equips.show', compact('equip', 'descripcio_ia'));
    }

    public function create()
    {
        $this->authorize('create', Equip::class);
        $estadis = Estadi::all(); 
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

    public function edit(Equip $equip)
    {
        $this->authorize('update', $equip);
        $estadis = Estadi::all();
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