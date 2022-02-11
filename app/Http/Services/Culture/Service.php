<?php

namespace App\Http\Services\Culture;

use App\Models\Culture;
use Illuminate\Support\Facades\Validator;

class Service
{
    public function validate($request)
    {
        return Validator::make($request->all(), [
            'culture' => 'unique:cultures|required|string|max:255'
        ], [
            'culture.required' => 'Поле не может быть пустым',
            'culture.unique' => 'Такая культура уже есть',
            'culture.string' => 'Поле должно быть строкой',
            'culture.max:255' => 'Поле не может быть длинее 255 символов',
        ]);
    }

    public function store($request)
    {
        return Culture::create([
            'culture' => $request->culture
        ]);
    }

    public function update($culture, $request)
    {
        $culture->update([
            'culture' => $request->culture
        ]);

        return $culture;
    }
}
