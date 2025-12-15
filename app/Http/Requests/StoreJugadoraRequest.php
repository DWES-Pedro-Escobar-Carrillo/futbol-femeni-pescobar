<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Jugadora;
use Carbon\Carbon;

class StoreJugadoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Jugadora::class);
    }

    public function rules(): array
    {
        // Càlcul data mínima (16 anys enrere)
        $dataMinima = Carbon::now()->subYears(16)->toDateString();

        return [
            'nom' => 'required|string|min:3',
            'equip_id' => 'required|integer|exists:equips,id',
            'data_naixement' => ['required', 'date', 'before_or_equal:' . $dataMinima],
            'dorsal' => 'required|integer|min:1|max:99', // Numèric positiu
            'foto' => 'nullable|image|mimes:png|max:2048', // Només PNG i màx 2MB
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