<?php

namespace App\Jobs;

use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class UrlProcessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Job $model
     */
    private $model;

    /**
     * Create a new job instance.
     *
     * @param Job $model
     */
    public function __construct(Job $model)
    {
        $this->model = $model;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->model->status != Job::DONE_STATUS) {
            $this->updateJobStatus(Job::PROCESSING_STATUS);
            $status = Job::ERROR_STATUS;
            try {
                $response = Http::get($this->model->url);
                if ($response->successful()) {
                    $status = Job::DONE_STATUS;
                }
                $this->updateJobStatus($status, $response->status());
            } catch (\Exception $exception) {
                $this->updateJobStatus($status);
            }
        }
    }

    /**
     * Update the job data.
     *
     * @param string $status
     * @param int|null $httpCode
     * @return void
     */
    private function updateJobStatus(string $status, int $httpCode = null)
    {
        $this->model->update(['status' => $status, 'http_code' => $httpCode]);
    }

    /**
     * Handle a job failure.
     *
     * @return void
     */
    public function failed()
    {
        $this->model->update(['status' => Job::ERROR_STATUS]);
    }
}
