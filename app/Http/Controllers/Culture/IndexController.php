<?php

namespace App\Http\Controllers\Culture;

use App\Http\Resources\Culture\CultureResource;
use App\Models\Culture;

class IndexController
{
    public function __invoke()
    {
        $data = Culture::all();
        return CultureResource::collection($data);
    }
}
