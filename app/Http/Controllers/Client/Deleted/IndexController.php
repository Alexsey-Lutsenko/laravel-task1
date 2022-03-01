<?php

namespace App\Http\Controllers\Client\Deleted;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;

class IndexController extends Controller
{
    public function __invoke()
    {
        $data = Client::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        return ClientResource::collection($data);
    }
}