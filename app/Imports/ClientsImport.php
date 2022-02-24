<?php

namespace App\Imports;

use App\Models\Client;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ClientsImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
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
