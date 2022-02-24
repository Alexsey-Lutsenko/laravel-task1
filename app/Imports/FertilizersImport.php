<?php

namespace App\Imports;

use App\Models\Fertilizer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class FertilizersImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if ($row->filter()->isNotEmpty()) {
                Fertilizer::firstOrCreate([
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
        }
    }
}
