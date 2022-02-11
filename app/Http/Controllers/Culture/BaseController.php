<?php

namespace App\Http\Controllers\Culture;

use App\Http\Controllers\Controller;
use App\Http\Services\Culture\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
