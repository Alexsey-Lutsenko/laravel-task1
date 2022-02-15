<?php

namespace App\Http\Controllers\Role;

use App\Http\Resources\Role\RoleResource;
use App\Models\Role;

class IndexController
{
    public function __invoke()
    {
        $data = Role::all();

        return RoleResource::collection($data);
    }
}
