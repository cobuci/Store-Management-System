<?php

use App\{Http\Controllers\HistoryController,
    Http\Controllers\InvoiceController,
    Http\Controllers\ocPackController,
    Http\Controllers\StatisticsController,
    Livewire\CustomerRegister,
    Livewire\Dashboard,
    Livewire\Inventory,
    Livewire\Pages\PackTool,
    Livewire\ProductAdd,
    Livewire\ProductRegister,
    Livewire\Reports,
    Livewire\Sale,
    Livewire\ShoppingList};
use App\Livewire\CustomerProfile;
use App\Livewire\Customers;
use App\Livewire\Finance;
use App\Livewire\Settings;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(callback: function () {

    //Dashboard
    Route::get('/', Dashboard::class)->name('admin.home');
    Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');

    //Products
    Route::get('/inventory', Inventory::class)->name('admin.inventory');
    Route::get('/product/register', ProductRegister::class)->name('admin.product.register');
    Route::get('/product/add', ProductAdd::class)->name('admin.product.add');

    //Customers
    Route::get('/customer', Customers::class)->name('admin.customer');
    Route::get('/customer/register', CustomerRegister::class)->name('admin.customer.register');
    Route::get('/customer/{id}', CustomerProfile::class)->name('admin.customer.profile');


    //Finances
    Route::get('/finances', Finance::class)->name('admin.finances');
    Route::get('/sale', Sale::class)->name('admin.sale');
    Route::get('/reports', Reports::class)->name('admin.reports');
    Route::get('/invoice/{id}', [InvoiceController::class, "show"])->name('invoice');


    //Tools
    Route::get('/statistics', [StatisticsController::class, "index"])->name('admin.estatisticas');
    Route::get('/shoppingList', ShoppingList::class)->name('admin.shoppinglist');

    Route::get('/tool/pack', PackTool::class)->name('admin.tool.pack');
    Route::POST('/pack/open', [ocPackController::class, "openPack"])->name('admin.pack.open');
    Route::POST('/pack/close', [ocPackController::class, "closePack"])->name('admin.pack.close');


    //Others
    Route::get('/settings',Settings::class)->name('admin.settings');
    Route::get('/historico', [HistoryController::class, "index"])->name('admin.historico');


});
