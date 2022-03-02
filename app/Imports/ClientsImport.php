<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Facades\Validator;

HeadingRowFormatter::default('none');

class ClientsImport implements ToCollection, WithHeadingRow, SkipsOnFailure
{
    use SkipsFailures;

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Validator::make($row->toArray(), [
                'client' => 'unique:clients|required|max:255|string',
                'agreementDate' => 'required|date',
                'purchase' => 'required|numeric',
                'region' => 'required|string|max:255'
            ])->validate();

            if ($row->filter()->isNotEmpty()) {
                Client::firstOrCreate([
                    'client' => $row['Наименование'],
                    'agreementDate' => $row['Дата договора'],
                    'purchase' => $row['Стоимость поставки'],
                    'region' => $row['Регион'],
                ]);
            }
        }
    }
}
