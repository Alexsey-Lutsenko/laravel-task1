<?php

namespace App\Http\Controllers\Fertilizer\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\UploadFertilizersJob;

class ImportController extends Controller
{
    public function __invoke(Request $request)
    {
        $file = $request->file('files');
        $filePath = $file->storeAs('imports', 'fertilizers.' . $file->getClientOriginalExtension());

        $errors = UploadFertilizersJob::dispatchSync($filePath);

        if ($errors) {
            return response(["messages" => "Данные импортированы с ошибками", "errorsImport" => json_encode($errors)], 206);
        }

        return response(["messages" => "Данные импортированы"], 200);
    }
}

