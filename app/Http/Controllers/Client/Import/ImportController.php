<?php

namespace App\Http\Controllers\Client\Import;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\UploadClientsJob;
use App\Models\ImportStatus;

class ImportController extends Controller
{
    public function __invoke(Request $request)
    {
        $file = $request->file('files');
        $filePath = $file->storeAs('imports', 'clients.' . $file->getClientOriginalExtension());
        $user_id = $request->user_id;
        $data = $request->data;

        UploadClientsJob::dispatchSync($filePath, $user_id, $data);
    }
}

