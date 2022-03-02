<?php

namespace App\Jobs;

// use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FertilizersImport;

class UploadFertilizersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, /*Queueable,*/ SerializesModels;

    private $path;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $filePath)
    {
        $this->path = $filePath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    protected $signature = 'excel:import:fertilizers';
    protected $description = 'Импорт показателей';

    public function handle()
    {
        Excel::import(new FertilizersImport(), $this->path, 'local');
        $import = new FertilizersImport();
        $import->import($this->path, 'local');

        $errors = [];
        foreach ($import->failures() as $failure) {
            $errors[] = [
                "row" => $failure->row(),
                "field" => $failure->attribute(),
                "errors" => $failure->errors(),
                "values" => $failure->values(),
            ];
        }
        return $errors;
    }
}
