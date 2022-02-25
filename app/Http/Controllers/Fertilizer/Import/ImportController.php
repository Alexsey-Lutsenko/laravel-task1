<?php

namespace App\Http\Controllers\Fertilizer\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\UploadFertilizersJob;

class ImportController extends Controller
{
    protected $signature = 'excel:import:indexes';
    protected $description = 'Импорт показателей';

    public function __invoke(Request $request)
    {
        $file = $request->file('files');
        $filePath = $file->storeAs('imports', 'fertilizers.' . $file->getClientOriginalExtension());

        UploadFertilizersJob::dispatchSync($filePath);

        return response(["messages" => "Данные импортированы"], 200);
    }
}

