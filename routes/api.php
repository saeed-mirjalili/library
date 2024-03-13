<?php

use App\Http\Controllers\authorController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\panelController;
use App\Http\Controllers\userController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


    



Route::post('register' ,[userController::class , 'register'])->name('register');
Route::post('login' ,[userController::class , 'login'])->name('login');


    Route::group(['middleware'=>['auth:sanctum']], function () {

        Route::post('logout', [userController::class , 'logout']);

        Route::apiResource('categories' ,categoryController::class);
        Route::apiResource('authors' ,authorController::class);
        Route::apiResource('books' ,bookController::class);

        Route::get('panel/{book}' ,[panelController::class , 'addBook']);
        Route::get('panel' ,[panelController::class , 'showBook']);
        Route::post('panel/add' ,[panelController::class , 'addBooks']);
        Route::post('panel/remove' ,[panelController::class , 'removeBooks']);

});