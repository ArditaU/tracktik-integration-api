<?php

namespace App\Http\Controllers;

use Exception;
use App\Jobs\SendEmployeeToTrackTik;
use App\Services\TrackTikService;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public $trackTikService;

    public function __construct(TrackTikService $trackTikService)
    {
        $this->trackTikService = $trackTikService;
    }

    public function store(Request $request)
    {
        $provider = $request->header('X-Provider');

        $providerRequest = "App\\Http\\Requests\\Create{$provider}EmployeeRequest";

        $employeeData = app($providerRequest)->validated();

        try {
            SendEmployeeToTrackTik::dispatch($employeeData, $provider);

            return response()->json(['message' => 'Employee queued for processing'], 202);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
