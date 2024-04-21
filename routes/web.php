<?php

use App\Helpers\Helper;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::prefix("auth")->group(function () {
    Route::get("/login", [AuthController::class, "index"])->name("login.get");
    Route::post("/login", [AuthController::class, "login"])->name("login.post");
    Route::get("/logout", [AuthController::class, "logout"])->name("logout");
});


    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::post('settings/update', [SettingController::class, 'update'])->name('setting.update');

Route::middleware(['authCheck'])->group(function () {
    Route::get('/', [DashboardController::class, "index"])->name("dashboard");

    Route::prefix('roles')->group(function () {
        Route::get('list', [RoleController::class, 'index'])->name('role.list');
        Route::post('store', [RoleController::class, 'store'])->name('role.store');
        Route::post('update', [RoleController::class, 'update'])->name('role.update');
        Route::get('destroy/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
    });

    Route::prefix("orders")->group(function () {
        Route::get('list', [OrderController::class, "index"])->name('order.list');
        Route::get('create', [OrderController::class, "create"])->name('order.create');
        Route::post('store', [OrderController::class, "store"])->name('order.store');
        Route::get('detail/{id}', [OrderController::class, "detail"])->name('order.detail');
        Route::get('xml/{id}', [OrderController::class, "xml"])->name('order.xml.create');
        Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
        Route::post('/update/{id}', [OrderController::class, 'update'])->name('order.update');
    });

    Route::prefix("current")->group(function () {
        Route::get('index', [CurrentController::class, "index"])->name('current.list');
        Route::get('detail/{code}', [CurrentController::class, "detail"])->name('current.detail');
    });
    Route::prefix("stock")->group(function () {
        Route::get('index', [StockController::class, "index"])->name('stock.list');
        Route::get('get/{code}', [StockController::class, 'getStock'])->name('stock.get');
    });

    Route::prefix('users')->group(function (){
        Route::get('list', [UserController::class, 'index'])->name('user.list');
        Route::post('store', [UserController::class, 'store'])->name('user.store');
        Route::post('update', [UserController::class, 'update'])->name('user.update');
        Route::get('destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::post('ChangePassword', [UserController::class, 'changePass'])->name('change.pass');  
});
