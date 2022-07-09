<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AliasController;

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

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/sites', 'sites.index')->name('sites');
    Route::view('/sites/create', 'sites.create');
    Route::view('/crontab', 'crontab')->name('crontab');
    Route::view('/services', 'services')->name('services');

    Route::get('/sites/index', [SiteController::class, 'index']);
    Route::get('/sites/create', [SiteController::class, 'create']);
    Route::post('/sites/create', [SiteController::class, 'store']);
    Route::get('/sites/{site}/edit/{section?}', [SiteController::class, 'edit']);
    Route::post('/sites/{site}/edit/{section?}', [SiteController::class, 'update']);
    Route::post('/sites/{site}/delete', [SiteController::class, 'destroy']);

    Route::post('/sites/{site}/edit/security/password', [SiteController::class, 'password']);
    Route::post('/sites/{site}/edit/security/database', [SiteController::class, 'database']);
    Route::post('/sites/{site}/edit/aliases/{id}', [AliasController::class, 'destroy']);

    Route::any('/sites/{site}/deploy/{pin}', [DeployController::class, 'run']);

    Route::get('/ajax/checkserverstatus', [AjaxController::class, 'checkServerStatus']);
    Route::get('/ajax/checkuniquedomain/{domain}/{site?}', [AjaxController::class, 'checkUniqueDomain']);
    Route::get('/ajax/getdeploykey/{username}', [AjaxController::class, 'getDeployKey']);
});
