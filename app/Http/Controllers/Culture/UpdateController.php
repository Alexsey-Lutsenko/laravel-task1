<?php

namespace App\Http\Controllers\Culture;

use App\Http\Requests\Culture\UpdateRequest;
use App\Http\Resources\Culture\CultureResource;
use App\Models\Culture;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Culture $culture)
    {
        $validated = $request->validated();

        $data = $this->service->update($culture, $validated);

        return new CultureResource($data);
    }
}
