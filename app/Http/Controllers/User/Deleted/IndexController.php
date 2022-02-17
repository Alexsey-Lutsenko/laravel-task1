<?php

namespace App\Http\Controllers\User\Deleted;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;

class IndexController extends Controller
{
    public function __invoke()
    {
        $data = User::onlyTrashed()->get();
        return UserResource::collection($data);
    }
}