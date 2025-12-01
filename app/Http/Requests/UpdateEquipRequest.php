<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $equipId = $this->route('equip')->id;

        return [
            'nom'    => [
                'required',
                'min:3',
                Rule::unique('equips')->ignore($equipId),
            ],
            'estadi_id' => 'required|integer|exists:estadis,id',
            'titols' => 'required|integer|min:0'
        ];
    }
}