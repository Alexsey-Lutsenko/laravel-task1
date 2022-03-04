<?php

namespace App\Http\Services\Client;

use App\Models\Client;
use \PhpOffice\PhpWord\PhpWord;
use \PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Storage;

class Service
{
    public function store($validated)
    {
        return Client::create($validated);
    }

    public function update($client, $validated)
    {
        $client->update($validated);

        return $client;
    }

    public function word($request)
    {
        // dd($request);
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addText('Справка', [
            'size' => 18, 'color' => '#000', 'bold' => true
        ], ['align' => 'center']);
        $section->addText('');
        $section->addText('Подтверждает действительность заключение договора от ' .  date('d.m.Y', strtotime($request->agreementDate)) .  ' с компанией "' . $request->client . 
        '" на сумму ' . number_format($request->purchase, 2, ',', ' ') . ' Руб.', [
            'size' => 13, 'color' => '#545454', 'italic' => true
        ]);
        $section->addText('');
        $section->addText(date('d.m.Y'), [
            'size' => 12, 'color' => '#000'
        ], ['align' => 'right']);
        $section->addText('С уважением, ИП Иванов. А. С.', [
            'size' => 12, 'color' => '#000'
        ], ['align' => 'right']);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app\public\agreement' . '.docx'));

        return Storage::path('public\agreement.docx');

    }
}
