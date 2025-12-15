<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Estadi;

class StoreEstadiRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Només si l'usuari té permís per crear estadis (definit a EstadiPolicy)
        return $this->user()->can('create', Estadi::class);
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|min:3|unique:estadis,nom',
            'capacitat' => 'required|integer|min:1', // Numèric positiu
        ];
    }
}