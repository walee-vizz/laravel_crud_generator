<?php

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\GenerateCrudController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
})->name('home');

Route::get('/home', function () {
    return redirect()->route('admin.dashboard');
})->name('homepage');


// Auth Routes::
Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware(Authenticate::class);

Route::controller(AuthController::class)->middleware(RedirectIfAuthenticated::class)->group(function () {

    Route::get('login', 'view')->name('login');
    Route::post('/login', 'login');

    Route::get('auth/google', 'redirectToGoogle')->name('login.with.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');

    Route::get('register', 'create')->name('register');
    Route::post('register', 'register');
});

// End Auth Routes::


Route::get('test-prefix', function(){


        dd(request()->get('dynamic_prefix', ''));

});

Route::prefix(request()->get('dynamic_prefix', ''))->name('admin.')->middleware(Authenticate::class)->group(function () {

    Route::controller(AdminDashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    Route::controller(RoleController::class)->middleware('permission:manage roles and permissions')->group(function () {
        Route::get('/roles', 'index')->middleware('permission:read roles')->name('roles');
        Route::get('/roles/create', 'create')->middleware('permission:create role')->name('roles.create');
        Route::post('/roles/create', 'store')->middleware('permission:create role');
        Route::get('/role/update/{role}', 'edit')->middleware('permission:edit role')->name('roles.update');
        Route::post('/role/update/{role}', 'update')->middleware('permission:edit role');
        Route::get('/role/delete/{role}', 'destroy')->middleware('permission:delete roles')->name('roles.delete');
    });
    Route::controller(PermissionController::class)->middleware('permission:manage roles and permissions')->group(function () {
        Route::get('/permissions', 'index')->middleware('permission:read permissions')->name('permissions');
        Route::get('/permissions/create', 'create')->middleware('permission:create permission')->name('permissions.create');
        Route::post('/permissions/create', 'store')->middleware('permission:create permission');
        Route::get('/permission/update/{permission}', 'edit')->middleware('permission:edit permission')->name('permissions.update');
        Route::post('/permission/update/{permission}', 'update')->middleware('permission:edit permission');
        Route::get('/permission/delete/{permission}', 'destroy')->middleware('permission:delete permission')->name('permissions.delete');
    });

    Route::controller(UserController::class)->middleware('permission:manage users')->group(function () {
        Route::get('/users', 'index')->middleware('permission:read users')->name('users');
        Route::get('/user/create', 'create')->middleware('permission:create user')->name('user.create');
        Route::post('/user/create', 'store')->middleware('permission:create user');
        Route::get('/user/update/{user}', 'edit')->middleware('permission:edit user')->name('user.update');
        Route::post('/user/update/{user}', 'update')->middleware('permission:edit user');
        Route::get('/user/profile/{user}', 'show')->name('user.view_profile');
        Route::get('/user/delete/{user}', 'destroy')->middleware('permission:delete user')->name('user.delete');

        Route::post('upload/user-profile/picture/', 'upload_picture')->name('user.upload.picture');
    });

    Route::controller(GenerateCrudController::class)->middleware('permission:create cruds')->group(function () {
        Route::get('generate-crud/form', 'generateCrudView')->name('generate_crud.view');
        Route::get('run-migration', 'run_migration')->name('run.migration');
        Route::post('generate-crud', 'generateCrudCommand')->name('generate_crud.submit');
        Route::get('crud-generation-success', 'crud_generation_success')->name('crud_generation_success');
    });
    Route::controller(AdminSettingController::class)->prefix('settings')->name('settings.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('save');
    });
});





Route::controller(LanguageController::class)->group(function () {

    Route::get('/test/{lang}',  'change')->name('lang.switch');
    Route::get('lang/home',  'index');
    Route::get('lang/change/{lang}',  'change')->name('changeLang');
});


Route::controller(ActivityLogController::class)->prefix('activity-log')->name('activity_log.')->group(function () {
    Route::get('/activity-logs', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{activity_log}', 'edit')->name('edit');
    Route::post('/update/{activity_log}', 'update')->name('update');
    Route::get('/destroy/{activity_log}', 'destroy')->name('destroy');
});




use App\Http\Controllers\WilmaElliController;
Route::controller(WilmaElliController::class)->prefix('wilma-elli')->name('wilma_elli.')->group(function(){
            Route::get('/', 'index')->middleware('permission:read wilmaellis')->name('index');
            Route::get('/create', 'create')->middleware('permission:create wilmaellis')->name('create');
            Route::post('/store', 'store')->middleware('permission:create wilmaellis')->name('store');
            Route::get('/edit/{wilma_elli}', 'edit')->middleware('permission:edit wilmaellis')->name('edit');
            Route::post('/update/{wilma_elli}', 'update')->middleware('permission:edit wilmaellis')->name('update');
            Route::get('/destroy/{wilma_elli}', 'destroy')->middleware('permission:delete wilmaellis')->name('destroy');

        });
