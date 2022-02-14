<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\User\UserResource;

class StoreController extends BaseController
{
    public function __invoke(StoreRequest $request)
    {
        $validator = $request->validated();

        $data = $this->service->store($validator);

        return new UserResource($data);
    }
}
