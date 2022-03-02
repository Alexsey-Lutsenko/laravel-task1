<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'client' => [
                'required',
                'string',
                'max:255',
                Rule::unique('clients')->whereNull('deleted_at'),
            ],
            'agreementDate' => 'required|date',
            'purchase' => 'required|numeric',
            'region' => 'required|string|max:255'
        ];
    }
}
