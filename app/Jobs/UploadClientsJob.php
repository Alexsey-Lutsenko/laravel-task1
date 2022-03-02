<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClientsImport;


class UploadClientsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


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
    protected $signature = 'excel:import:clients';
    protected $description = 'Импорт показателей';

    public function handle()
    {
        $import = new ClientsImport();
        Excel::import(new ClientsImport(), $this->path, 'local');

        foreach ($import->failures() as $failure) {
            dd($failure);
            $failure->row(); // row that went wrong
            $failure->attribute(); // either heading key (if using heading row concern) or column index
            $failure->errors(); // Actual error messages from Laravel validator
            $failure->values(); // The values of the row that has failed.
       }
    }
}
