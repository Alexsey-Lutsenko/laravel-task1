<?php

namespace App\Http\Controllers\Fertilizer\Export;

use App\Exports\FertilizersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Http\Resources\Fertilizer\FertilizerResource;
use App\Models\Fertilizer;

class ExportController extends Controller 
{
    public function __invoke()
    {
        $fertilizers = Fertilizer::get();

        return Excel::download(new FertilizersExport($fertilizers), 'fertilizers.xlsx');
    }
}