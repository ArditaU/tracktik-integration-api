<?php

namespace App\Services;

use Exception;
use App\Models\ProviderEmployee;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TrackTikService
{
    protected $oauth2Service;

    public function __construct(OAuth2Service $oauth2Service) {
        $this->oauth2Service = $oauth2Service;
    }

    public function sendEmployeeData($data, $provider)
    {
        $client = new Client();
        $accessToken = $this->oauth2Service->getAccessToken();

        $mappingService = "App\\Services\\Mapping\\{$provider}Mapper";
        $mappedData = app($mappingService)->map($data);

        $employee = ProviderEmployee::where('provider_name', $provider)
            ->where('provider_employee_id', $data['id'])
            ->first();

        try {
            if ($employee) {
                $id = $employee->tracktik_employee_id;

                $response = $client->put("employees/$id", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Accept' => 'application/json',
                    ],
                    'json' => $mappedData,
                ]);
            } else {
                $idempotencyKey = 'myApp-' . Str::uuid();

                $response = $client->post('employees', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Accept' => 'application/json',
                        'Idempotency-Key' => $idempotencyKey
                    ],
                    'json' => $mappedData,
                ]);

                $tracktikResponse = json_decode($response->getBody(), true);

                ProviderEmployee::create([
                    'provider_name' => $provider,
                    'provider_employee_id' => $data['id'],
                    'tracktik_employee_id' => $tracktikResponse['id'],
                ]);
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }
}