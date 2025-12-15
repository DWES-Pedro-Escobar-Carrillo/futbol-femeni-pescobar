<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('partit'));
    }

    public function rules(): array
    {
        // REGLES DINÀMIQUES:
        // Si és àrbitre, només validem els gols.
        // Si és admin, validem tot (equips, data, estadi...).
        
        if ($this->user()->role === 'arbitre') {
            return [
                'gols_local' => 'required|integer|min:0',
                'gols_visitant' => 'required|integer|min:0',
            ];
        }

        // Regles per a l'Admin
        return [
            'local_id' => 'required|integer|exists:equips,id|different:visitant_id',
            'visitant_id' => 'required|integer|exists:equips,id',
            'estadi_id' => 'required|integer|exists:estadis,id',
            'data' => 'required|date',
            'jornada' => 'required|integer|min:1',
            'gols_local' => 'nullable|integer|min:0',
            'gols_visitant' => 'nullable|integer|min:0',
            'arbitre_id' => 'nullable|exists:users,id',
        ];
    }
}