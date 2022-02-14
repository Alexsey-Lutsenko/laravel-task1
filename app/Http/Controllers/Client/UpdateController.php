<?php

namespace App\Http\Controllers\Client;

use App\Http\Requests\Client\UpdateRequest;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;

class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request, Client $client)
    {
        $validated = $request->validated();

        $data = $this->service->update($client, $validated);

        return new ClientResource($data);
    }
}
