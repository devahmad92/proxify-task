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
        if (in_array($this->model->status, [Job::NEW_STATUS, Job::ERROR_STATUS])) {
            $this->model->update(['status' => Job::PROCESSING_STATUS]);
            try {
                $result = Http::get($this->model->url);
                $status = Job::DONE_STATUS;
                if ($result->failed()) {
                    $status = Job::ERROR_STATUS;
                }
                $this->model->update(['status' => $status, 'http_code' => $result->status()]);
            } catch (\Exception $e) {
                $this->model->update(['status' => Job::ERROR_STATUS]);
            }
        }
    }
}
