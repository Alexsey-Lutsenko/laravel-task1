<?php

namespace App\Http\Services\Culture;

use App\Models\Culture;

class Service
{
    public function store($validated)
    {
        return Culture::create($validated);
    }

    public function update($culture, $validated)
    {
        $culture->update($validated);

        return $culture;
    }

    public function destroy($culture)
    {
        If($culture->fertilisers->count() > 0) {
            return 2;
        }

        $isDelete = $culture->delete();

        if (!$isDelete) {
            return 1;
        }

        return 0;
    }
}
