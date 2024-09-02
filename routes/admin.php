<?php

use App\Http\Controllers\Admin\Admin_panel_settingsController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\Sales_material_typesController;
use App\Http\Controllers\Admin\TreasuriesController;

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

define('PAGINATION_COUNT', 7);

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
    // Route::get('logout', function() {
    //     auth()->logout();
    // });
    Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/adminpanelsetting/index', [Admin_panel_settingsController::class, 'index'])->name('admin.adminPanelSetting.index');
    Route::get('/adminpanelsetting/edit', [Admin_panel_settingsController::class, 'edit'])->name('admin.adminPanelSetting.edit');
    Route::post('/adminpanelsetting/update', [Admin_panel_settingsController::class, 'update'])->name('admin.adminPanelSetting.update');
    /*         start treasuries           */
    Route::get('/treasuries/index', [TreasuriesController::class, 'index'])->name('admin.treasuries.index');
    Route::get('/treasuries/create', [TreasuriesController::class, 'create'])->name('admin.treasuries.create');
    Route::post('/treasuries/store', [TreasuriesController::class, 'store'])->name('admin.treasuries.store');
    Route::get('/treasuries/edit/{id}', [TreasuriesController::class, 'edit'])->name('admin.treasuries.edit');
    Route::post('/treasuries/update/{id}', [TreasuriesController::class, 'update'])->name('admin.treasuries.update');
    Route::post('/treasuries/ajax_search', [TreasuriesController::class, 'ajax_search'])->name('admin.treasuries.ajax_search');
    Route::get('/treasuries/details/{id}', [TreasuriesController::class, 'details'])->name('admin.treasuries.details');
    Route::get('/treasuries/add_treasuries_delivery/{id}', [TreasuriesController::class, 'add_treasuries_delivery'])->name('admin.treasuries.add_treasuries_delivery');
    Route::post('/treasuries/store_treasuries_delivery/{id}', [TreasuriesController::class, 'store_treasuries_delivery'])->name('admin.treasuries.store_treasuries_delivery');
    Route::get('/treasuries/delete_treasuries_delivery/{id}', [TreasuriesController::class, 'delete_treasuries_delivery'])->name('admin.treasuries.delete_treasuries_delivery');

    /*         end treasuries             */

    /*         start sales_material_types           */
    Route::get('/sales_material_types/index', [Sales_material_typesController::class, 'index'])->name('admin.sales_material_types.index');
    Route::get('/sales_material_types/create', [Sales_material_typesController::class, 'create'])->name('admin.sales_material_types.create');
    Route::post('/sales_material_types/store', [Sales_material_typesController::class, 'store'])->name('admin.sales_material_types.store');
    Route::get('/sales_material_types/edit/{id}', [Sales_material_typesController::class, 'edit'])->name('admin.sales_material_types.edit');
    Route::post('/sales_material_types/update/{id}', [Sales_material_typesController::class, 'update'])->name('admin.sales_material_types.update');
    Route::get('/sales_material_types/delete_material_types/{id}', [Sales_material_typesController::class, 'delete_material_types'])->name('admin.sales_material_types.delete_material_types');



    /*         end sales_material_types           */
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'guest:admin'], function() {
    Route::get('login', [LoginController::class, 'show_login_view'])->name('admin.showLogin');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
});
