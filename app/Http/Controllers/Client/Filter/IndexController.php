<?php

namespace App\Http\Controllers\Client\Filter;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $client = $request->client;
        $regions = $request->regions;
        $agreementDateFrom = $request->agreementDateFrom ? $request->agreementDateFrom : '01.01.0001';
        $agreementDateTo = $request->agreementDateTo ? $request->agreementDateTo : '31.12.9999';
        $purchaseFrom = $request->purchaseFrom ? $request->purchaseFrom : 0;
        $purchaseTo = $request->purchaseTo ? $request->purchaseTo : 9999999999;

        $orderByClient = $request->orderByClient;
        $orderByPurchase = $request->orderByPurchase;
       
        $data = Client::where('client', 'like', "%{$client}%")
                        ->whereBetween('agreementDate',[$agreementDateFrom, $agreementDateTo])
                        ->whereBetween('purchase',[$purchaseFrom , $purchaseTo])
                        ->when($regions, function($query, $regions) {
                            return $query->whereIn('region', $regions);
                        })
                        ->when($orderByClient, function($query, $regions) {
                            return $query->orderBy('client', 'asc');
                        })
                        ->when($orderByPurchase, function($query, $regions) {
                            return $query->orderBy('purchase', 'asc');
                        })
                        ->get();
        
        return ClientResource::collection($data);
    }
}
