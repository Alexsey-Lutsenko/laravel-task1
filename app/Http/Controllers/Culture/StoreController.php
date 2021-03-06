<?php

namespace App\Http\Controllers\Culture;

use App\Http\Requests\Culture\StoreRequest;
use App\Http\Resources\Culture\CultureResource;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();

        $data = $this->service->store($validated);

        return new CultureResource($data);
    }
}
