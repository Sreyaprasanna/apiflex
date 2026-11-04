<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ApiTableController;
use App\Http\Controllers\Api\ApiFieldController;
use App\Http\Controllers\Api\DynamicApiController;



// Dynamic API endpoints (mock data)
Route::get('/{projectSlug}/{tableName}', [DynamicApiController::class, 'index']);
Route::post('/{projectSlug}/{tableName}', [DynamicApiController::class, 'store']);
