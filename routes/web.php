<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectWebController;
use App\Http\Controllers\Api\ProjectController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard & Projects
Route::get('/dashboard', [ProjectController::class, 'dashboard'])->name('dashboard');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
















// Tables & Fields under a project
Route::post('/projects/{project}/tables', [ProjectController::class, 'storeTable'])->name('projects.tables.store');
Route::get('/projects/{project}/tables/{table}', [ProjectController::class, 'showTable'])->name('projects.tables.show');
Route::delete('/projects/{project}/tables/{table}', [ProjectController::class, 'destroyTable'])->name('projects.tables.destroy');
