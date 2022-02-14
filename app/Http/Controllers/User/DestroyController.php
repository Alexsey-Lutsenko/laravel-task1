<?php

namespace App\Http\Controllers\User;

use App\Models\User;

class DestroyController extends BaseController
{
    public function __invoke(User $user)
    {
        $name = $user->name;

        $isDelete = $user->delete();

        if (!$isDelete) {
            return response(['message' => "Пользователя $name удалить не удалось"], 500);
        }
        return response(['message' => "Пользователь $name успешно удален"], 200);
    }
}
