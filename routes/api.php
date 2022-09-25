<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Endpoints that need to only be accessible to authenticated users. Luckily for us, we can do that using the sanctum authenticated guard.
// See https://www.twilio.com/blog/build-restful-api-php-laravel-sanctum
// This will make sure requests to this endpoint contain a valid API token in the header.
Route::post('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
