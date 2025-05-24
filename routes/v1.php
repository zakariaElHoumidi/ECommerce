<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CategoryControlleur;
use App\Http\Controllers\api\ProductControlleur;
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

Route::name("guests.")->middleware(["guest:sanctum"])->prefix("/")->group(function () {
    Route::name("auth.")->prefix("/user-auth")->group(function () {
        Route::post('login', [AuthController::class, 'userLogin']);

        Route::post('register', [AuthController::class, 'userRegister']);
    });

    Route::name("auth.")->prefix("/admin-auth")->group(function () {
        Route::post('login', [AuthController::class, 'adminLogin']);

        Route::post('register', [AuthController::class, 'adminRegister']);
    });
});

Route::name("administrateurs.")->middleware(['auth:sanctum'])->prefix("/admin")->group(function () {
    Route::name("categories.")->prefix("/categories")->group(function () {
        Route::get('/', [CategoryControlleur::class, 'index']);
        Route::post('/', [CategoryControlleur::class, 'store']);
        Route::get('/{id}', [CategoryControlleur::class, 'show']);
        Route::put('/edit/{id}', [CategoryControlleur::class, 'update']);
        Route::delete('/{id}', [CategoryControlleur::class, 'destroy']);
    });

    Route::name("products.")->prefix("/products")->group(function () {
        Route::get('/', [ProductControlleur::class, 'index']);
        Route::post('/', [ProductControlleur::class, 'store']);
        Route::get('/{id}', [ProductControlleur::class, 'show']);
        Route::put('/edit/{id}', [ProductControlleur::class, 'update']);
        Route::delete('/{id}', [ProductControlleur::class, 'destroy']);
    });

    Route::post('logout', [AuthController::class, 'logout']);
});

Route::name("users.")->middleware(['auth:sanctum'])->prefix("/members")->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);
});
