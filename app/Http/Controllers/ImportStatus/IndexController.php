<?php

namespace App\Http\Controllers\ImportStatus;

use App\Http\Resources\ImportStatus\ImportStatusResource;
use App\Models\ImportStatus;

class IndexController
{
    public function __invoke()
    {
        $data = ImportStatus::orderBy('id', 'desc')->paginate(10);
        return ImportStatusResource::collection($data);
    }
}
