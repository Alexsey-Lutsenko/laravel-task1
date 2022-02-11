<?php

namespace App\Http\Services\User;

use Illuminate\Support\Facades\Validator;

class Service
{
    public function validate($request)
    {
        return Validator::make($request->all(),[
            'name' => 'unique:users|required|max:255|string',
            'role_id' => 'number'
        ], [
            'name.required' => 'Поле не может быть пустым',
            'name.unique' => 'Такой пользователь уже есть',
            'name.string' => 'Поле должно быть строкой',
            'name.max:255' => 'Поле не может быть длинее 255 символов',
            'role_id.number' => 'Id роли не корректный'
        ]);
    }

    public function store()
    {

    }

    public function update()
    {

    }
}
