<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;

// For Firebase / Firestore CRUD test functions
use App\Http\Controllers\TestController;

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
Route::get('/categories', [CategoryController::class, 'allCategories']);

// Protected Routes
// Endpoints that need to only be accessible to authenticated users. Luckily for us, we can do that using the sanctum authenticated guard.
// See https://www.twilio.com/blog/build-restful-api-php-laravel-sanctum
// This will make sure requests to this endpoint contain a valid API token in the header.
// Route::post('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
	Route::post('/me', [AuthController::class, 'me']);
	Route::resource('/collections', CollectionController::class);

	// API route for logout user
	Route::post('/logout', [AuthController::class, 'logout']);
});


// Firebase / Firestore CRUD test functions
// From https://www.twilio.com/blog/create-restful-crud-api-php-using-laravel-google-firebase
Route::post('/', [TestController::class, 'create']);
Route::get('/', [TestController::class, 'index']);
Route::put('/', [TestController::class, 'edit']);
Route::delete('/', [TestController::class, 'delete']);

