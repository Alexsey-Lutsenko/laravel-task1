<?php

namespace App\Http\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class Service
{

    public function store($validator)
    {
        return User::create($validator);
    }

    public function update($user, $validator)
    {
        $user->update($validator);

        return $user;
    }
}
