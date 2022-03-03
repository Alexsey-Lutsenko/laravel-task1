<?php

namespace App\Http\Controllers\Client\Export;

use App\Exports\ClientsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Client;

class ExportController extends Controller 
{
    public function __invoke()
    {
        $clients = Client::get();

        return Excel::download(new ClientsExport($clients), 'clients.xlsx');
    }
}