<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CartControlleur;
use App\Http\Controllers\api\CategoryControlleur;
use App\Http\Controllers\api\OrderControlleur;
use App\Http\Controllers\api\ProductControlleur;
use App\Http\Controllers\api\RatingControlleur;
use Illuminate\Support\Facades\Route;

/*
    Route::name("")->middleware([])->prefix("")->group(function () {
        Route::get('', [NameController::class, 'func'])->name('');
        Route::post('', [NameController::class, 'func'])->name('');

        Route::name("")->middleware([])->prefix("")->group(function () {
            Route::get('', [NameController::class, 'func'])->name('');
        });
    });
*/

Route::middleware(["guest:sanctum"])->group(function () {
    Route::name("user-auth.")->prefix("/user-auth")->group(function () {
        Route::post('login', [AuthController::class, 'userLogin']);

        Route::post('register', [AuthController::class, 'userRegister']);
    });

    Route::name("admin-auth.")->prefix("/admin-auth")->group(function () {
        Route::post('login', [AuthController::class, 'adminLogin']);

        Route::post('register', [AuthController::class, 'adminRegister']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);

    Route::name("administrateurs.")->middleware('is.admin')->prefix("/admin")->group(function () {
        Route::name("categories.")->prefix("/categories")->group(function () {
            Route::get('/', [CategoryControlleur::class, 'index']);
            Route::post('/', [CategoryControlleur::class, 'store']);
            Route::get('/{id}', [CategoryControlleur::class, 'show']);
            Route::put('/{id}', [CategoryControlleur::class, 'update']);
            Route::delete('/{id}', [CategoryControlleur::class, 'destroy']);
        });

        Route::name("products.")->prefix("/products")->group(function () {
            Route::get('/', [ProductControlleur::class, 'index']);
            Route::post('/', [ProductControlleur::class, 'store']);
            Route::get('/{id}', [ProductControlleur::class, 'show']);
            Route::put('/{id}', [ProductControlleur::class, 'update']);
            Route::delete('/{id}', [ProductControlleur::class, 'destroy']);
        });

        Route::name("ratings.")->prefix("/products/{id}/ratings")->group(function () {
            Route::get('/', [RatingControlleur::class, 'index']);
            Route::get('/{rating_id}', [RatingControlleur::class, 'show']);
        });

        Route::name("orders.")->prefix("/orders")->group(function () {
            Route::get('/', [OrderControlleur::class, 'index']);
            Route::get('/{id}', [OrderControlleur::class, 'show']);
        });

        Route::post('logout', [AuthController::class, 'logout']);
    });

    Route::name("users.")->middleware('is.user')->prefix("/")->group(function () {
        Route::name("categories.")->prefix("/categories")->group(function () {
            Route::get('/', [CategoryControlleur::class, 'index']);
        });

        Route::name("products.")->prefix("/products")->group(function () {
            Route::get('/', [ProductControlleur::class, 'index']);
        });

        Route::name("ratings.")->prefix("/products/{id}/ratings")->group(function () {
            Route::get('/', [RatingControlleur::class, 'index']);
            Route::post('/', [RatingControlleur::class, 'store']);
        });

        Route::name("carts.")->prefix("/carts")->group(function () {
            Route::get('/', [CartControlleur::class, 'index']);
            Route::post('/', [CartControlleur::class, 'store']);
        });

        Route::name("orders.")->prefix("/orders")->group(function () {
            Route::get('/', [OrderControlleur::class, 'index']);
            Route::get('/{id}', [OrderControlleur::class, 'show']);
            Route::post('/', [OrderControlleur::class, 'store']);
        });

        Route::post('logout', [AuthController::class, 'logout']);
    });
});
