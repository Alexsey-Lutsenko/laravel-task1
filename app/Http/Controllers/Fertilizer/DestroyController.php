<?php

namespace App\Http\Controllers\Fertilizer;

use App\Http\Controllers\Controller;
use App\Models\Fertilizer;

class DestroyController extends Controller
{
    public function __invoke(Fertilizer $fertilizer)
    {
        $name = $fertilizer->fertilizer;

        $isDelete = $fertilizer->delete();

        if (!$isDelete) {
            return response(["messages" => "$name не удалось удалить"], 500);
        }
        return response(["messages" => "$name удален успешно"], 200);
    }
}
