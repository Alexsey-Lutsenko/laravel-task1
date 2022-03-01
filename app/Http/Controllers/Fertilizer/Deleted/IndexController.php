<?php

namespace App\Http\Controllers\Fertilizer\Deleted;

use App\Http\Controllers\Controller;
use App\Http\Resources\Fertilizer\FertilizerResourceDeleted;
use App\Models\Fertilizer;

class IndexController extends Controller
{
    public function __invoke()
    {
        $data = Fertilizer::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        return FertilizerResourceDeleted::collection($data);
    }
}