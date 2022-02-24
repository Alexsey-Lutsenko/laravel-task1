<?php

namespace App\Http\Controllers\Fertilizer\Import;

use App\Imports\FertilizersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    protected $signature = 'excel:import:indexes';
    protected $description = 'Импорт показателей';

    public function __invoke(Request $request)
    {
        $filePath = $request->file('files');
        Excel::import(new FertilizersImport(), $filePath);
    }
}

