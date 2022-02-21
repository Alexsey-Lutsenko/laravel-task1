<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class FertilizerFilter extends AbstractFilter
{
    public const FERTILIZER = 'fertilizer';
    public const NORM_N = 'normN';
    public const NORM_P = 'normP';
    public const NORM_K = 'normK';
    public const CULTURE_ID = 'culture_id';
    public const REGION = 'region';
    public const PRICE = 'price';
    public const DESCRIPTION = 'description';
    public const PURPOSE = 'purpose';
    public const ORDER_BY_FERTILIZER = 'orderByFertilizer';
    public const ORDER_BY_PRICE = 'orderByPrice';

    protected function getCallbacks(): array
    {
        return [
            self::FERTILIZER => [$this, 'fertilizer'],
            self::NORM_N => [$this, 'normN'],
            self::NORM_P => [$this, 'normP'],
            self::NORM_K => [$this, 'normK'],
            self::CULTURE_ID => [$this, 'culture_id'],
            self::REGION => [$this, 'region'],
            self::PRICE => [$this, 'price'],
            self::DESCRIPTION => [$this, 'description'],
            self::PURPOSE => [$this, 'purpose'],
            self::ORDER_BY_FERTILIZER => [$this, 'orderByFertilizer'],
            self::ORDER_BY_PRICE => [$this, 'orderByPrice'],
        ];
    }

    public function fertilizer(Builder $builder, $value)
    {
        $builder->where('fertilizer', 'like', "%{$value}%");
    }

    public function normN(Builder $builder, $value)
    {
        $builder->whereBetween('normN', $value);
    }

    public function normP(Builder $builder, $value)
    {
        $builder->whereBetween('normP', $value);
    }

    public function normK(Builder $builder, $value)
    {
        $builder->whereBetween('normK', $value);
    }

    public function culture_id(Builder $builder, $value)
    {
        $builder->whereIn('culture_id', $value);
    }

    public function region(Builder $builder, $value)
    {
        $builder->whereIn('region', $value);
    }

    public function price(Builder $builder, $value)
    {
        $builder->whereBetween('price', $value);
    }

    public function description(Builder $builder, $value)
    {
        $builder->where('description', 'like', "%{$value}%");
    }

    public function purpose(Builder $builder, $value)
    {
        $builder->where('purpose', 'like', "%{$value}%");
    }

    public function orderByFertilizer(Builder $builder, $value)
    {
        $builder->orderBy('fertilizer', 'asc');
    }

    public function orderByPrice(Builder $builder, $value)
    {
        $builder->orderBy('price', 'asc');
    }
}
