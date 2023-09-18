<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenerateCrudController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('generate-crud', [GenerateCrudController::class, 'generateCrudCommand']);



use App\Http\Controllers\ActivityLogController;
Route::controller(ActivityLogController::class)->prefix('activity-log')->name('activity_log.')->group(function(){
            Route::get('/', 'index');
            Route::post('/store', 'store');
            Route::post('/update/{activity_log}', 'update');
            Route::get('/destroy/{activity_log}', 'destroy');

        });


use App\Http\Controllers\AdminSettingController;
Route::controller(AdminSettingController::class)->prefix('setting')->name('setting.')->group(function(){
            Route::get('/', 'index');
            Route::post('/store', 'store');
            Route::post('/update/{setting}', 'update');
            Route::get('/destroy/{setting}', 'destroy');

        });



