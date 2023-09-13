<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CaixaController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\FinancaController;
use App\Http\Controllers\InvestimentoController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ocPackController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShoppingListController;

Route::middleware('auth:sanctum')->group(function () {



    Route::get('/invoice/{id}', [InvoiceController::class, "show"])->name('invoice');


    Route::get('/settings', [SettingsController::class, "index"])->name('admin.settings');

    Route::POST('/order/store', [OrderController::class, "store"])->name('admin.orders.store');

    Route::delete('/relatorio/{id}', [OrderController::class, "destroy"])->name('order.destroy');

    Route::POST('/relatorio/{id}', [OrderController::class, "changeStatusOrder"])->name('order.status');



    Route::get('/', [DashboardController::class, "index"])->name('admin.home');


    // Estatisticas


    Route::get('/estatisticas', [StatisticsController::class, "index"])->name('admin.estatisticas');


    Route::get('/searchCustomer', [CustomerController::class, "search"])->name('customer.search');


    Route::get('/shoppingList', [ShoppingListController::class, "index"])->name('admin.shoppinglist');

    Route::POST('/shoppingList/add', [ShoppingListController::class, "entradaLista"])->name('admin.shoppinglist.add');

    Route::delete('/shoppingList/{id}', [ShoppingListController::class, "destroy"])->name('order.shop.destroy');




    Route::get('/pack', [ocPackController::class, "index"])->name('admin.ocpack');
    Route::POST('/pack/open', [ocPackController::class, "openPack"])->name('admin.pack.open');
    Route::POST('/pack/close', [ocPackController::class, "closePack"])->name('admin.pack.close');


    Route::get('/dashboard', [DashboardController::class, "index"])->name('admin.dashboard');

    Route::POST('/dashboard/meta', [CaixaController::class, "definirMeta"])->name('admin.dashboard.meta');
    // Dados

    Route::get('/financas', [CaixaController::class, "index"])->name('admin.financas');


    Route::get('/relatorio', [OrderController::class, "index"])->name('admin.relatorio');



    Route::get('/historico', [HistoryController::class, "index"])->name('admin.historico');

    Route::POST('/investimento/adicionar', [InvestimentoController::class, "adicionar"])->name('admin.investimento.add');

    Route::POST('/investimento/remover', [InvestimentoController::class, "remover"])->name('admin.investimento.remove');



    Route::delete('/financa/{id}', [FinancaController::class, "destroy"])->name('financa.destroy');

    // Produto
    Route::get('/load_prod_cat', [EntradaController::class, "load"])->name('load_prod_cat');


    Route::delete('/produto/{id}', [ProductController::class, "destroy"])->name('product.destroy');
    Route::put('/produto/{id}', [ProductController::class, "put"])->name('product.edit');

    // Estoque
    //GET
    Route::get('/cadastrar', [ProductController::class, "index"])->name('admin.cadastrar');

    Route::get('/estoque', [EstoqueController::class, "index"])->name('admin.estoque');

    Route::get('/entrada', [EntradaController::class, "index"])->name('admin.entrada');


    //POST
    Route::POST('/entradaestoque', [EntradaController::class, "entradaProdutos"])->name('admin.entradaestoque');

    Route::POST('/cadastrarproduto', [ProductController::class, "store"])->name('admin.product.new');

    // Venda
    Route::POST('/vender/loja', [VendaController::class, "vendaLoja"])->name('admin.venda.loja');


    Route::delete('/venda/{id}', [VendaController::class, "destroy"])->name('venda.destroy');

    // Clientes

    Route::get('/customer', [CustomerController::class, "index"])->name('admin.customer');

    Route::get('/customer/register', [CustomerController::class, "cadastrar"])->name('admin.customer.register');
    Route::post('/customer/store', [CustomerController::class, "store"])->name('admin.customer.store');
    Route::get('/cliente/{id}', [CustomerController::class, "show"])->name('admin.cliente.perfil');

    Route::get('/customer/filter', [CustomerController::class, "filtrar"])->name('customer.filter');

    Route::get('/customer/filter/report', [OrderController::class, "filtrarRelatorio"])->name('customer.report');

    Route::delete('/cliente/{id}', [CustomerController::class, "destroy"])->name('cliente.destroy');
    Route::put('/cliente/{id}', [CustomerController::class, "put"])->name('cliente.editar');

    /////////////////////////////////////



    Route::get('/vender', function () {
        return view('admin.vender');
    })->name('admin.vender');


});
