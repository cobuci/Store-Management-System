<?php

use App\{Http\Controllers\HistoryController,
    Http\Controllers\InvoiceController,
    Livewire\Pages\CustomerRegister,
    Livewire\Pages\Dashboard,
    Livewire\Pages\Inventory,
    Livewire\Pages\PackTool,
    Livewire\Pages\ProductAdd,
    Livewire\Pages\ProductRegister,
    Livewire\Pages\Reports,
    Livewire\Pages\Sale,
    Livewire\Pages\ShoppingList,
    Livewire\Pages\Statistics};
use App\Livewire\Pages\CustomerProfile;
use App\Livewire\Pages\Customers;
use App\Livewire\Pages\Finance;
use App\Livewire\Pages\Settings;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(callback: function () {

    //Dashboard
    Route::get('/', Dashboard::class)->name('admin.home')->lazy();
    Route::get('/dashboard', Dashboard::class)->name('admin.dashboard')->lazy();

    //Products
    Route::get('/inventory', Inventory::class)->name('admin.inventory')->lazy();
    Route::get('/product/register', ProductRegister::class)->name('admin.product.register');
    Route::get('/product/add', ProductAdd::class)->name('admin.product.add');

    //Customers
    Route::get('/customer', Customers::class)->name('admin.customer')->lazy();
    Route::get('/customer/register', CustomerRegister::class)->name('admin.customer.register');
    Route::get('/customer/{id}', CustomerProfile::class)->name('admin.customer.profile');


    //Finances
    Route::get('/finances', Finance::class)->name('admin.finances')->lazy();
    Route::get('/sale', Sale::class)->name('admin.sale');
    Route::get('/reports', Reports::class)->name('admin.reports')->lazy();
    Route::get('/invoice/{id}', [InvoiceController::class, "show"])->name('invoice');


    //Tools
    Route::get('/statistics', Statistics::class)->name('admin.tool.statistics')->lazy();
    Route::get('/tools/shopping', ShoppingList::class)->name('admin.tool.shopping');

    Route::get('/tools/pack', PackTool::class)->name('admin.tool.pack');

    //Others
    Route::get('/settings',Settings::class)->name('admin.settings');
    Route::get('/history', [HistoryController::class, "index"])->name('admin.history');


});
