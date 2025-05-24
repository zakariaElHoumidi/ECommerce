<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Forme générale :
 *
 * Route::name("")->middleware([])->prefix("")->group(function () {
 *      Direct Route:
 *      Route::get('', [NameController::class, 'func'])->name('');
 *      Route::post('', [NameController::class, 'func'])->name('');
 *
 *      OR SubGroup:
 *      Route::name("")->middleware([])->prefix("")->group(function () {
 *          Route::get('', [NameController::class, 'func'])->name('');
 *      });
 * });
 *
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name("guests")->middleware(["guest:sanctum"])->prefix("/")->group(function () {
    Route::name("auth.")->prefix("/user-auth")->group(function () {
        Route::post('login', [AuthController::class, 'userLogin']);

        Route::post('register', [AuthController::class, 'userRegister']);
    });

    Route::name("auth.")->prefix("/admin-auth")->group(function () {
        Route::post('login', [AuthController::class, 'adminLogin']);

        Route::post('register', [AuthController::class, 'adminRegister']);
    });
});
