<?php

namespace App\Http\Requests\Fertilizer;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fertilizer' => "unique:fertilizers|required|string|max:255",
            'normN' => "required|numeric",
            'normP' => "required|numeric",
            'normK' => "required|numeric",
            'culture_id' => "exists:cultures,id",
            'region' => "required|string|max:255",
            'price' => "required|numeric",
            'description' => "",
            'purpose' => "required|string|max:255",
        ];
    }
}
