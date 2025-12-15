<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Partit;

class StorePartitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Partit::class);
    }

    public function rules(): array
    {
        return [
            'local_id' => 'required|integer|exists:equips,id|different:visitant_id',
            'visitant_id' => 'required|integer|exists:equips,id',
            'estadi_id' => 'required|integer|exists:estadis,id',
            'data' => 'required|date',
            'jornada' => 'required|integer|min:1',
            'gols_local' => 'nullable|integer|min:0', // Numèric positiu o zero
            'gols_visitant' => 'nullable|integer|min:0',
            'arbitre_id' => 'nullable|exists:users,id',
        ];
    }
    
    public function messages(): array
    {
        return [
            'local_id.different' => "L'equip local i visitant no poden ser el mateix.",
        ];
    }
}