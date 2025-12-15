<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Equip;
use App\Models\Partit;

class Classificacio extends Component
{
    public function render()
    {
        // 1. Obtenim tots els equips
        $equips = Equip::all();
        
        // 2. Obtenim només els partits jugats (amb resultat)
        $partits = Partit::whereNotNull('gols_local')
                         ->whereNotNull('gols_visitant')
                         ->get();

        // 3. Inicialitzem l'array d'estadístiques per a cada equip
        $stats = [];
        foreach ($equips as $equip) {
            $stats[$equip->id] = [
                'nom' => $equip->nom,
                'escut' => $equip->escut,
                'punts' => 0,
                'jugats' => 0,
                'guanyats' => 0,
                'empatats' => 0,
                'perduts' => 0,
                'gf' => 0, // Gols a favor
                'gc' => 0, // Gols en contra
                'dg' => 0, // Diferència de gols
            ];
        }

        // 4. Processem els partits per sumar punts i gols
        foreach ($partits as $partit) {
            $local = $partit->local_id;
            $visitant = $partit->visitant_id;
            $golsL = (int) $partit->gols_local;
            $golsV = (int) $partit->gols_visitant;

            // Actualitzem Gols i Partits Jugats
            if (isset($stats[$local])) {
                $stats[$local]['jugats']++;
                $stats[$local]['gf'] += $golsL;
                $stats[$local]['gc'] += $golsV;
                $stats[$local]['dg'] = $stats[$local]['gf'] - $stats[$local]['gc'];
            }

            if (isset($stats[$visitant])) {
                $stats[$visitant]['jugats']++;
                $stats[$visitant]['gf'] += $golsV;
                $stats[$visitant]['gc'] += $golsL;
                $stats[$visitant]['dg'] = $stats[$visitant]['gf'] - $stats[$visitant]['gc'];
            }

            // Assignem Punts (3 per victòria, 1 per empat)
            if ($golsL > $golsV) {
                // Guanya Local
                if (isset($stats[$local])) {
                    $stats[$local]['punts'] += 3;
                    $stats[$local]['guanyats']++;
                }
                if (isset($stats[$visitant])) {
                    $stats[$visitant]['perduts']++;
                }
            } elseif ($golsL < $golsV) {
                // Guanya Visitant
                if (isset($stats[$visitant])) {
                    $stats[$visitant]['punts'] += 3;
                    $stats[$visitant]['guanyats']++;
                }
                if (isset($stats[$local])) {
                    $stats[$local]['perduts']++;
                }
            } else {
                // Empat
                if (isset($stats[$local])) {
                    $stats[$local]['punts'] += 1;
                    $stats[$local]['empatats']++;
                }
                if (isset($stats[$visitant])) {
                    $stats[$visitant]['punts'] += 1;
                    $stats[$visitant]['empatats']++;
                }
            }
        }

        // 5. Ordenem: Primer per Punts, després per Diferència de Gols
        $classificacio = collect($stats)->sort(function ($a, $b) {
            if ($a['punts'] === $b['punts']) {
                return $b['dg'] <=> $a['dg']; // Si empaten a punts, mira la diferència
            }
            return $b['punts'] <=> $a['punts']; // Ordena per punts DESC
        });

        return view('livewire.classificacio', [
            'taula' => $classificacio
        ]);
    }
}