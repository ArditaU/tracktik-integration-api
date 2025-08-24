<?php

use App\Http\Controllers\ProviderController;
use Illuminate\Support\Facades\Route;

Route::post('/provider/employee', [ProviderController::class, 'store'])->middleware('provider.auth');
