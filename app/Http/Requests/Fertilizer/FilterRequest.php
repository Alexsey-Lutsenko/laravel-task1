<?php

namespace App\Http\Requests\Fertilizer;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'fertilizer' => "string|max:255",
            'normN' => "",
            'normP' => "",
            'normK' => "",
            'culture_id' => "",
            'region' => "",
            'price' => "",
            'description' => "",
            'purpose' => "string|max:255",
            'orderByFertilizer' => "",
            'orderByPrice' => "",
        ];
    }
}
