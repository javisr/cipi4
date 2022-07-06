<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AjaxController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/sites', function () {
        return view('sites');
    })->name('sites');

    Route::get('/sites/index', [SiteController::class, 'index']);
    Route::get('/sites/create', [SiteController::class, 'create']);
    Route::post('/sites/create', [SiteController::class, 'store']);
    Route::get('/sites/edit/{id}', [SiteController::class, 'show']);
    Route::post('/sites/edit/{id}', [SiteController::class, 'update']);
    Route::get('/sites/delete/{id}', [SiteController::class, 'destroy']);

    Route::get('/ajax/checkuniquedomain/{domain}/{site?}', [AjaxController::class, 'checkUniqueDomain']);

    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');


});
