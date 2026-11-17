<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ApiTableController;
use App\Http\Controllers\Api\postmancontroller;
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
// Route::get('/dashboard', [ApiTableController::class, 'showTable'])->name('dashboard');
Route::get('/projects', [ProjectController::class, 'indexWeb'])->name('projects.index');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

// Tables under a project
Route::post('/projects/{project}/tables', [ApiTableController::class, 'storeTable'])->name('projects.tables.store');
Route::get('/projects/{project}/tables/{table}', [ApiTableController::class, 'showTable'])->name('projects.tables.show');
Route::delete('/projects/{project}/tables/{table}', [ApiTableController::class, 'destroyTable'])->name('projects.tables.destroy');



//postman like
Route::get('/tester', [postmancontroller::class, 'globalTester'])->name('tester');
Route::get('/projects/{project}/tester', [postmancontroller::class, 'tester'])->name('projects.tester');
Route::post('/projects/{project}/tester/send', [postmancontroller::class, 'send'])->name('projects.tester.send');
Route::get('/projects/{project}/tester/export', [postmancontroller::class, 'exportCollection'])->name('projects.tester.export');