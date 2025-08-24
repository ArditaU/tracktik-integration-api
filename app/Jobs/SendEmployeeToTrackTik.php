<?php

namespace App\Jobs;

use Exception;
use App\Services\OAuth2Service;
use App\Services\TrackTikService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendEmployeeToTrackTik implements ShouldQueue
{
    use Queueable;

    protected $employeeData;
    protected $provider;

    /**
     * Create a new job instance.
     */
    public function __construct($employeeData, $provider)
    {
        $this->employeeData = $employeeData;
        $this->provider = $provider;
    }

    /**
     * Execute the job.
     */
    public function handle(TrackTikService $service): void
    {
        try {
            $service->sendEmployeeData($this->employeeData, $this->provider);
        } catch (Exception $e) {
            Log::error('TrackTik Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
