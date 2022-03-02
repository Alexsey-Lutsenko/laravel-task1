<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

HeadingRowFormatter::default('none');

class ClientsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        return new Client([
            'client' => $row['Наименование'],
            'agreementDate' => $row['Дата договора'],
            'purchase' => $row['Стоимость поставки'],
            'region' => $row['Регион'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.Наименование' => [
                'required',
                'string',
                'max:255',
                Rule::unique('clients', 'client')->whereNull('deleted_at'),
            ],
            '*.Дата договора' => 'required|date',
            '*.Стоимость поставки' => 'required|numeric',
            '*.Регион' => 'required|string|max:255'
        ];
    }
}
