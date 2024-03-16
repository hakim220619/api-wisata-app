<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GeneralController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'getUsers'])->name('getUsers');
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/getWisata', [GeneralController::class, 'getWisata'])->name('getWisata');
    Route::post('/getDetailWisata', [GeneralController::class, 'getDetailWisata'])->name('getDetailWisata');
    Route::post('/listCommentById', [GeneralController::class, 'listCommentById'])->name('listCommentById');
    Route::post('/addCommentById', [GeneralController::class, 'addCommentById'])->name('addCommentById');
    Route::post('/rate', [GeneralController::class, 'rate'])->name('rate');
    Route::post('/add-wisata', [GeneralController::class, 'addWisata'])->name('addWisata');
    Route::post('/update-wisata', [GeneralController::class, 'updateWisata'])->name('updateWisata');
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
