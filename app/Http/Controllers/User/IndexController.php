<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\User\UserResource;
use App\Models\User;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $data = User::all();
        return UserResource::collection($data);
    }
}
