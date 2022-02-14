<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;

class DestroyController extends Controller
{
    public function __invoke(Client $client)
    {
        $name = $client->client;

        $isDelete = $client->delete();

        if (!$isDelete) {
            return response(["messages" => "$name не удалось удалить"], 500);
        }
        return response(["messages" => "$name удален успешно"], 200);
    }
}
