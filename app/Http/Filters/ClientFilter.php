<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ClientFilter extends AbstractFilter
{
    public const CLIENT = 'client';
    public const AGREEMENT_DATE= 'agreementDate';
    public const PURCHASE = 'purchase';
    public const REGION = 'region';
    public const ORDER_BY_CLIENT = 'orderByClient';
    public const ORDER_BY_PURCHASE = 'orderByPurchase';

    protected function getCallbacks(): array
    {
        return [
            self::CLIENT => [$this, 'client'],
            self::REGION => [$this, 'region'],
            self::PURCHASE => [$this, 'purchase'],
            self::AGREEMENT_DATE => [$this, 'agreementDate'],
            self::ORDER_BY_CLIENT => [$this, 'orderByClient'],
            self::ORDER_BY_PURCHASE => [$this, 'orderByPurchase'],
        ];
    }

    public function client(Builder $builder, $value)
    {
        $builder->where('client', 'like', "%{$value}%");
    }

    public function region(Builder $builder, $value)
    {
        $builder->whereIn('region', $value);
    }

    public function purchase(Builder $builder, $value)
    {
        $builder->whereBetween('purchase', $value);
    }

    public function agreementDate(Builder $builder, $value)
    {
        $builder->whereBetween('agreementDate', $value);
    }

    public function orderByClient(Builder $builder, $value)
    {
        $builder->orderBy('client', 'asc');
    }

    public function orderByPurchase(Builder $builder, $value)
    {
        $builder->orderBy('purchase', 'asc');
    }
}
