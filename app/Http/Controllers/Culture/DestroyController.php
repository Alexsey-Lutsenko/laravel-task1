<?php

namespace App\Http\Controllers\Culture;

use App\Models\Culture;

class DestroyController
{
    public function __invoke(Culture $culture)
    {
        $name = $culture->culture;

        $isDelete = $culture->delete();

        if (!$isDelete) {
            return response(['message' => "$name удалить не удалось"]);
        }
        return response(['message' => "$name успешно удалено"]);
    }
}
