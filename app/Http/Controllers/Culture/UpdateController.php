<?php

namespace App\Http\Controllers\Culture;

use App\Http\Resources\Culture\CultureResource;
use App\Models\Culture;
use Illuminate\Http\Request;

class UpdateController extends BaseController
{
    public function __invoke(Request $request, Culture $culture)
    {
        $validator = $this->service->validate($request);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->all()], 422);
        }

        $data = $this->service->update($culture, $request);
        return new CultureResource($data);
    }
}
