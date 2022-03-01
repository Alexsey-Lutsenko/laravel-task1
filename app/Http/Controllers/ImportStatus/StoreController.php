<?php

namespace App\Http\Controllers\ImportStatus;

use App\Http\Requests\ImportStatus\StoreRequest;
use App\Http\Resources\ImportStatus\ImportStatusResource;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validated = $request->validated();

        $data = $this->service->store($validated);

        return new ImportStatusResource($data);
    }
}
