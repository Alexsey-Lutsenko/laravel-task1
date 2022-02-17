<?php

namespace App\Http\Controllers\Fertilizer\Deleted;

use App\Http\Controllers\Controller;
use App\Http\Resources\Fertilizer\FertilizerResource;
use App\Models\Fertilizer;

class IndexController extends Controller
{
    public function __invoke()
    {
        $data = Fertilizer::onlyTrashed()->get();
        return FertilizerResource::collection($data);
    }
}