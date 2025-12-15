<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UpdateJugadoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Verifica si aquest usuari pot editar AQUESTA jugadora específica
        return $this->user()->can('update', $this->route('jugadora'));
    }

    public function rules(): array
    {
        $dataMinima = Carbon::now()->subYears(16)->toDateString();

        return [
            'nom' => 'required|string|min:3',
            // El manager no hauria de poder canviar l'equip lliurement, però ho validem igualment
            'equip_id' => 'required|integer|exists:equips,id',
            'data_naixement' => ['required', 'date', 'before_or_equal:' . $dataMinima],
            'dorsal' => 'required|integer|min:1|max:99',
            'foto' => 'nullable|image|mimes:png|max:2048',
        ];
    }
    
    public function messages(): array
    {
        return [
            'data_naixement.before_or_equal' => 'La jugadora ha de tenir almenys 16 anys.',
            'foto.mimes' => 'La foto ha de ser obligatòriament en format PNG.',
        ];
    }
}