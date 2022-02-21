<?php

namespace App\Http\Controllers\Fertilizer;

use App\Http\Controllers\Controller;
use App\Http\Filters\FertilizerFilter;
use App\Http\Requests\Fertilizer\FilterRequest;
use App\Http\Resources\Fertilizer\FertilizerResource;
use App\Models\Fertilizer;

class IndexController extends BaseController
{
    public function __invoke(FilterRequest $request)
    {
        $data = $request->validated();

        $filter = app()->make(FertilizerFilter::class, ['queryParams' => array_filter($data)]);

        $fertilizers = Fertilizer::filter($filter)->get();

        return FertilizerResource::collection($fertilizers);
    }
}
