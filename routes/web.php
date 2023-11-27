<?php

use App\{Http\Controllers\InvoiceController,
    Livewire\Pages\CustomerRegister,
    Livewire\Pages\Dashboard,
    Livewire\Pages\Histories,
    Livewire\Pages\Inventory,
    Livewire\Pages\PackTool,
    Livewire\Pages\ProductAdd,
    Livewire\Pages\ProductRegister,
    Livewire\Pages\Purchase,
    Livewire\Pages\Reports,
    Livewire\Pages\Sale,
    Livewire\Pages\ShoppingList,
    Livewire\Pages\Statistics,};
use App\Livewire\Components\ShowReceipt;
use App\Livewire\Pages\CheckReceipt;
use App\Livewire\Pages\CustomerProfile;
use App\Livewire\Pages\Customers;
use App\Livewire\Pages\Finance;
use App\Livewire\Pages\Settings;
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
    Route::get('/purchase', Purchase::class)->name('admin.purchase');


    //Tools
    Route::get('/statistics', Statistics::class)->name('admin.tool.statistics');
    Route::get('/tools/shopping', ShoppingList::class)->name('admin.tool.shopping');

    Route::get('/tools/pack', PackTool::class)->name('admin.tool.pack');

    Route::get('/check-receipt', CheckReceipt::class)->name('admin.tool.check-receipt');
    Route::get('/check-receipt/{id}', ShowReceipt::class)->name('admin.tool.show-receipt');


    //Others
    Route::get('/settings', Settings::class)->name('admin.settings');
    Route::get('/history', Histories::class)->name('admin.history');
});
