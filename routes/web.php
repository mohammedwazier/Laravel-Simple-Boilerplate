<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuListCT;
use App\Http\Controllers\UserListCT;
use App\Http\Controllers\SettingCT;

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

Route::group(['middleware' => ['nologin']], function(){
    Route::get('/', [AuthController::class, 'loginPage'])->name('homeLoginPage');
    Route::get('/login', [AuthController::class, 'loginPage'])->name('loginPage');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('loginProcess');
});

Route::group(['middleware' => ['authlogin', 'authroutes'], 'prefix' => 'dashboard', 'as' => 'dashboard.'], function(){
    // /dashboard/*
    Route::get('/', function () {
        return view('dashboard.dashboard.index');
    });

    Route::group(['prefix' => 'config', 'as' => 'config.'], function(){
        Route::resource('menu', MenuListCT::class)->except(['destroy', 'create', 'show']);
        route::get('/menu/destroy/{id}', [MenuListCT::class, 'destroy'])->name('menu.destroy');
        Route::get('/menu/up/{id}/target/{target}', [MenuListCT::class, 'changeMenu'])->name('menu.up');
        Route::get('/menu/down/{id}/target/{target}', [MenuListCT::class, 'changeMenu'])->name('menu.down');

        Route::resource('user', UserListCT::class)->except(['destroy', 'create', 'show', 'edit']);
        Route::get('/user/edit/{id}/type/{type}', [UserListCT::class, 'edit'])->name('user.edit');
        Route::get('/user/destroy/{id}/type/{type}', [UserListCT::class, 'destroy'])->name('user.destroy');

        Route::resource('setting', SettingCT::class)->except(['destroy', 'create', 'show']);
        Route::get('/setting/destroy/{id}', [SettingCT::class, 'destroy'])->name('setting.destroy');
    });

    Route::get('/logout', [AuthController::class, 'logoutProcess'])->name('logoutProcess');
});
