<?php

namespace App\Http\Controllers\Fertilizer;

use App\Http\Requests\Fertilizer\StoreRequest;
use App\Http\Resources\Fertilizer\FertilizerResource;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();

        $data = $this->service->create($validated);

        return new FertilizerResource($data);
    }
}
