<?php

use Illuminate\Support\Facades\Route;

use App\{Http\Controllers\CaixaController,
    Http\Controllers\CustomerController,
    Http\Controllers\DashboardController,
    Http\Controllers\HistoryController,
    Http\Controllers\ProductController,
    Http\Controllers\InventoryController,
    Http\Controllers\EntradaController,
    Http\Controllers\StatisticsController,
    Http\Controllers\FinanceController,
    Http\Controllers\InvestimentoController,
    Http\Controllers\InvoiceController,
    Http\Controllers\ocPackController,
    Http\Controllers\OrderController,
    Http\Controllers\SettingsController,
    Http\Controllers\ShoppingListController,
    Livewire\CustomerRegister,
    Livewire\Dashboard,
    Livewire\Inventory,
    Livewire\ProductAdd,
    Livewire\ProductRegister,
    Livewire\Sale,
    Livewire\ShoppingList};

Route::middleware('auth:sanctum')->group(callback: function () {

    Route::get('/invoice/{id}', [InvoiceController::class, "show"])->name('invoice');

    Route::get('/settings', [SettingsController::class, "index"])->name('admin.settings');

    Route::POST('/order/store', [OrderController::class, "store"])->name('admin.orders.store');

    Route::delete('/report/{id}', [OrderController::class, "destroy"])->name('order.destroy');

    Route::POST('/report/{id}', [OrderController::class, "changeStatusOrder"])->name('order.status');



    Route::get('/', Dashboard::class)->name('admin.home');

    // Estatisticas


    Route::get('/estatisticas', [StatisticsController::class, "index"])->name('admin.estatisticas');


    Route::get('/shoppingList', ShoppingList::class)->name('admin.shoppinglist');



    Route::get('/pack', [ocPackController::class, "index"])->name('admin.ocpack');
    Route::POST('/pack/open', [ocPackController::class, "openPack"])->name('admin.pack.open');
    Route::POST('/pack/close', [ocPackController::class, "closePack"])->name('admin.pack.close');


    Route::get('/dashboard',Dashboard::class)->name('admin.dashboard');

    Route::POST('/dashboard/meta', [CaixaController::class, "definirMeta"])->name('admin.dashboard.meta');
    // Dados

    Route::get('/financas', [CaixaController::class, "index"])->name('admin.financas');


    Route::get('/reports', [OrderController::class, "index"])->name('admin.reports');


    Route::get('/historico', [HistoryController::class, "index"])->name('admin.historico');

    Route::POST('/investimento/adicionar', [InvestimentoController::class, "adicionar"])->name('admin.investimento.add');

    Route::POST('/investimento/remover', [InvestimentoController::class, "remover"])->name('admin.investimento.remove');



    Route::delete('/financa/{id}', [FinanceController::class, "destroy"])->name('financa.destroy');

    // Produto
    Route::get('/load_prod_cat', [EntradaController::class, "load"])->name('load_prod_cat');


    Route::delete('/produto/{id}', [ProductController::class, "destroy"])->name('product.destroy');
    Route::put('/produto/{id}', [ProductController::class, "put"])->name('product.edit');

    Route::POST('/cadastrarproduto', [ProductController::class, "store"])->name('admin.product.new');

    // Estoque
    //GET
    Route::get('/product/register', ProductRegister::class)->name('admin.product.register');

    Route::get('/inventory', Inventory::class)->name('admin.inventory');

    Route::get('/product/add', ProductAdd::class)->name('admin.product.add');


    //POST
    Route::POST('/entradaestoque', [EntradaController::class, "entradaProdutos"])->name('admin.entradaestoque');


    // Clientes
    Route::get('/customer/filter', [CustomerController::class, "filter"])->name('customer.filter');

    Route::get('/customer', [CustomerController::class, "index"])->name('admin.customer');
    Route::get('/searchCustomer', [CustomerController::class, "search"])->name('customer.search');
    Route::get('/customer/register', CustomerRegister::class)->name('admin.customer.register');
    Route::post('/customer/store', [CustomerController::class, "store"])->name('admin.customer.store');
    Route::get('/customer/{id}', [CustomerController::class, "show"])->name('admin.customer.profile');


    Route::get('/customer/filter/report', [OrderController::class, "filterReport"])->name('customer.report');

    Route::delete('/customer/{id}', [CustomerController::class, "destroy"])->name('customer.destroy');
    Route::put('/customer/{id}', [CustomerController::class, "put"])->name('customer.edit');


    Route::get('/sale', Sale::class)->name('admin.sale');


});
