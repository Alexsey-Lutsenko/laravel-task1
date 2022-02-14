<?php

namespace App\Http\Services\Client;

use App\Models\Client;

class Service
{
    public function store($validated)
    {
        return Client::create($validated);
    }

    public function update($client, $validated)
    {
        $client->update($validated);

        return $client;
    }
}
