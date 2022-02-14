<?php

namespace App\Http\Services\Fertilizer;

use App\Models\Fertilizer;

class Service
{
    public function create($validated)
    {
        return Fertilizer::create($validated);
    }

    public function update($fertilizer, $validated)
    {
        $fertilizer->update($validated);

        return $fertilizer;
    }
}
