<?php

namespace App\Imports;

use App\Models\Fertilizer;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

HeadingRowFormatter::default('none');

class FertilizersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        return new Fertilizer([
            'fertilizer' => $row['Наименование'],
            'normN' => $row['Норма Азот'],
            'normP' => $row['Норма Фосфор'],
            'normK' => $row['Норма Калий'],
            'region' => $row['Район'],
            'price' => $row['Стоимость'],
            'description' => $row['Описание'],
            'purpose' => $row['Назначение'],
            'culture_id' => $row['Культура ID'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.Наименование' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fertilizers', 'fertilizer')->whereNull('deleted_at'),
            ],
            '*.Норма Азот' => "required|numeric",
            '*.Норма Фосфор' => "required|numeric",
            '*.Норма Калий' => "required|numeric",
            '*.Культура ID' => "exists:cultures,id",
            '*.Район' => "required|string|max:255",
            '*.Стоимость' => "required|numeric",
            '*.Описание' => "",
            '*.Назначение' => "required|string|max:255",
        ];
    }

}
