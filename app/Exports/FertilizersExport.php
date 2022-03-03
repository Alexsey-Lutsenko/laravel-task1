<?php

namespace App\Exports;

use App\Models\Fertilizer;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FertilizersExport implements FromView, ShouldAutoSize, WithStyles
{
    public $fertilizers;

    public function __construct($fertilizers)
    {
        $this->fertilizers = $fertilizers;
    }

    public function view(): View
    {
        return view('excel.exports.fertilizers', [
            'fertilizers' => $this->fertilizers
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
