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
        $user_id = $request->user_id;
        $data = $request->data;

        UploadFertilizersJob::dispatchSync($filePath, $user_id, $data);
    }
}

