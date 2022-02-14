<?php

namespace App\Http\Controllers\Culture;

use App\Models\Culture;

class DestroyController extends BaseController
{
    public function __invoke(Culture $culture)
    {
        $name = $culture->culture;

        $delete = $this->service->destroy($culture);

        if ($delete === 2) {
            return response(['message' => "Запись $name связана с другой таблицей, удалить невозможно"], 500);
        } else if ($delete === 1) {
            return response(['message' => "$name не удалось удалить"], 500);
        } else {
            return response(['message' => "$name успешно удалено"], 200);
        }
    }
}
