<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\Client\StoreRequest;
use App\Http\Resources\Client\ClientResource;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();

        $data = $this->service->store($validated);

        return new ClientResource($data);
    }
}
