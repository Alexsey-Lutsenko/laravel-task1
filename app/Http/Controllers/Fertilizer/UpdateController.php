<?php

namespace App\Http\Controllers\Fertilizer;

use App\Http\Requests\Fertilizer\UpdateRequest;
use App\Http\Resources\Fertilizer\FertilizerResource;
use App\Models\Fertilizer;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Fertilizer $fertilizer)
    {
        $validated = $request->validated();

        $data = $this->service->update($fertilizer, $validated);

        return new FertilizerResource($data);
    }
}
