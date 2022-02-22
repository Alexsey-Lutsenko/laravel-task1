<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\User\UserResource;
use App\Models\User;

class IndexController extends BaseController
{
    public function __invoke()
    {
        $data = User::whereNull('email')->get();
        return UserResource::collection($data);
    }
}
