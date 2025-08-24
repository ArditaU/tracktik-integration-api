<?php

namespace App\Services;

use Exception;
use App\Models\OauthToken;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class OAuth2Service
{
    protected $client;
    protected $clientId;
    protected $clientSecret;
    protected $service;


    public function __construct() {
        $this->client = new Client(['base_uri' => config('services.staffr.base_url')]);
        $this->clientId = config('services.staffr.client_id');
        $this->clientSecret = config('services.staffr.client_secret');
        $this->service = 'staffr';
    }

    public function getAccessToken()
    {
        return Cache::remember("oauth_staffr_access_token", 3600, function () {
            $token = OauthToken::where('service', $this->service)->first();

            if (!$token) {
                throw new Exception('No token found for this service');
            }

            $response = $this->client->post('oauth2/access_token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'refresh_token' => $token->refresh_token
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            $token->update([
                'refresh_token' => $data['refresh_token'] ?? $token->refresh_token,
                'expires_at' => now()->addSeconds(isset($data['expires_in']) ? (int) $data['expires_in'] : 3600),
            ]);

            return $data['access_token'];
        });
    }
}