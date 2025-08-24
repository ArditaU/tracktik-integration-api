<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProviderAuth
{
    protected $validTokens;

    public function __construct() {
        $this->validTokens = [
            'Provider1' => env('PROVIDER1_TOKEN'),
            'Provider2' => env('PROVIDER2_TOKEN'),
        ];
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('X-Api-Token');
        $provider = $request->header('X-Provider');

        if (!$provider || !isset($this->validTokens[$provider])) {
            return response()->json(['error' => 'Invalid provider'], 422);
        }

        if (!$token || $token !== $this->validTokens[$provider]) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
