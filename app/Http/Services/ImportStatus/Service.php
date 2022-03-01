<?php

namespace App\Http\Services\ImportStatus;

use App\Models\ImportStatus;
use Illuminate\Support\Facades\Validator;

class Service
{

    public function store($validator)
    {
        return ImportStatus::create($validator);
    }
}
