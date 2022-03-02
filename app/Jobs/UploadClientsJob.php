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
use App\Models\ImportStatus;

class UploadClientsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $path;
    private $user_id;
    private $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $filePath, int $user_id, string $data)
    {
        $this->path = $filePath;
        $this->user_id = $user_id;
        $this->data = $data;
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
        if(count($errors) > 0) {
            ImportStatus::create(
                ['status' => 'Данные импортированы с ошибками',
                'errors_array' => json_encode($errors),
                'data' => $this->data,
                'user_id' => $this->user_id],
             );
        } else {
            ImportStatus::create(
                ['status' => 'Данные импортированы',
                'data' => $this->data,
                'user_id' => $this->user_id],
             );
        }
    }
}
