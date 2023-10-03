<?php

use App\{Http\Controllers\HistoryController,
    Http\Controllers\InvoiceController,
    Livewire\CustomerRegister,
    Livewire\Dashboard,
    Livewire\Inventory,
    Livewire\Pages\PackTool,
    Livewire\Pages\Statistics,
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
    Route::get('/statistics', Statistics::class)->name('admin.tool.statistics');
    Route::get('/tools/shopping', ShoppingList::class)->name('admin.tool.shopping');

    Route::get('/tools/pack', PackTool::class)->name('admin.tool.pack');

    //Others
    Route::get('/settings',Settings::class)->name('admin.settings');
    Route::get('/history', [HistoryController::class, "index"])->name('admin.history');


});
