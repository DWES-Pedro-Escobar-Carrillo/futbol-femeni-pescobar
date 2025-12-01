<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipRequest extends FormRequest
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
    return [
        'nom'       => 'required|min:3|unique:equips,nom',
        'estadi_id' => 'required|integer|exists:estadis,id',
        'titols'    => 'required|integer|min:0',
        'escut'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Màx 2MB
    ];
}
}