<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEstadiRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Fem servir la policy sobre l'estadi que s'està editant
        return $this->user()->can('update', $this->route('estadi'));
    }

    public function rules(): array
    {
        $estadiId = $this->route('estadi')->id;

        return [
            'nom' => [
                'required',
                'string',
                'min:3',
                Rule::unique('estadis')->ignore($estadiId),
            ],
            'capacitat' => 'required|integer|min:1',
        ];
    }
}