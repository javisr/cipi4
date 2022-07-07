<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\SiteController;

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

    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/sites', 'sites.index')->name('sites');
    Route::view('/sites/create', 'sites.create');
    Route::view('/settings', 'settings')->name('settings');

    Route::get('/sites/index', [SiteController::class, 'index']);
    Route::get('/sites/create', [SiteController::class, 'create']);
    Route::post('/sites/create', [SiteController::class, 'store']);
    Route::get('/sites/edit/{site}', [SiteController::class, 'edit']);
    Route::post('/sites/edit/{site}', [SiteController::class, 'update']);
    Route::post('/sites/delete/{site}', [SiteController::class, 'destroy']);

    Route::get('/ajax/checkserverstatus', [AjaxController::class, 'checkServerStatus']);
    Route::get('/ajax/checkuniquedomain/{domain}/{site?}', [AjaxController::class, 'checkUniqueDomain']);

});
