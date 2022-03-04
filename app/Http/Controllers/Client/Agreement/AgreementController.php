<?php

namespace App\Http\Controllers\Client\Agreement;

use App\Http\Controllers\Client\BaseController;
use App\Http\Requests\Client\AgreementRequest;
use Exception;
use Illuminate\Support\Facades\Response;

class AgreementController extends BaseController
{
    public function __invoke(AgreementRequest $request)
    {
        $path = $this->service->word($request);

        try {
            return Response::download($path, 'agreement.docx');
        } catch (Exception $e) {
            return response(['message'=> $e->getMessage()], 500);
        }
    }
}
