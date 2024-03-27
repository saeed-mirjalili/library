<?php

use App\Http\Controllers\library\authorController;
use App\Http\Controllers\library\bookController;
use App\Http\Controllers\library\categoryController;
use App\Http\Controllers\panel\panelController;
use App\Http\Controllers\user\userController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });






Route::post('register' ,[userController::class , 'register']);
Route::post('login' ,[userController::class , 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::delete('logout', [userController::class , 'logout']);

        Route::apiResource('categories' ,categoryController::class);
        Route::apiResource('authors' ,authorController::class);
        Route::apiResource('books' ,bookController::class);

        Route::get('panel/{book}' ,[panelController::class , 'addBook']);
        Route::get('panel' ,[panelController::class , 'showBook']);
        Route::post('panel/add' ,[panelController::class , 'addBooks']);
        Route::post('panel/remove' ,[panelController::class , 'removeBooks']);
    });
