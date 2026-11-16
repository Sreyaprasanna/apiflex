<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DynamicApiController;

/*
|--------------------------------------------------------------------------
| Dynamic Mock REST API Routes
|--------------------------------------------------------------------------
*/


// Seed 5 dummy records with Faker
Route::post('/{projectSlug}/{tableName}/seed', [DynamicApiController::class, 'seed'])->name('api.seed');
Route::prefix('{projectSlug}')
    ->middleware('api.key')
    ->group(function () {
        Route::get('/{tableName}', [DynamicApiController::class, 'index']);
        Route::post('/{tableName}', [DynamicApiController::class, 'store']);
        Route::get('/{tableName}/{id}', [DynamicApiController::class, 'show']);
        Route::put('/{tableName}/{id}', [DynamicApiController::class, 'update']);
        Route::delete('/{tableName}/{id}', [DynamicApiController::class, 'destroy']);
    });