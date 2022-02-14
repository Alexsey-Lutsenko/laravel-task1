<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;

class IndexController extends Controller
{
    public function __invoke()
    {
        $data = Client::all();

        return ClientResource::collection($data);
    }
}
