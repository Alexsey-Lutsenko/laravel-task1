<?php

namespace App\Http\Controllers\Culture\Deleted;

use App\Http\Controllers\Controller;
use App\Http\Resources\Culture\CultureResource;
use App\Models\Culture;

class IndexController extends Controller
{
    public function __invoke()
    {
        $data = Culture::onlyTrashed()->get();
        return CultureResource::collection($data);
    }
}