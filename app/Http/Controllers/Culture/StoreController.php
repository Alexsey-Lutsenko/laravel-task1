<?php

namespace App\Http\Controllers\Culture;

use App\Http\Resources\Culture\CultureResource;
use Illuminate\Http\Request;

class StoreController extends BaseController
{
    public function __invoke(Request $request)
    {
        $validator = $this->service->validate($request);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()->all()], 422);
        }

        $data = $this->service->store($request);
        return new CultureResource($data);
    }
}
