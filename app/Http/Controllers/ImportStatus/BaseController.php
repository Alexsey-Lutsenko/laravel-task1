<?php

namespace App\Http\Controllers\ImportStatus;

use App\Http\Controllers\Controller;
use App\Http\Services\ImportStatus\Service;

class BaseController extends Controller
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
