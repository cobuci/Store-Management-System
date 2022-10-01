<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CaixaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\FinancaController;
use App\Http\Controllers\InvestimentoController;
use App\Http\Controllers\ocPackController;
use App\Http\Controllers\OrderController;

Route::middleware('auth:sanctum')->group(function () {


    Route::POST('/order/store', [OrderController::class, "store"])->name('admin.orders.store');

    Route::delete('/relatorio/{id}', [OrderController::class, "destroy"])->name('order.destroy');

    Route::POST('/relatorio/{id}', [OrderController::class, "changeStatusOrder"])->name('order.status');



    Route::get('/', [DashboardController::class, "index"])->name('admin.home');


    Route::get('/pack', [ocPackController::class, "index"])->name('admin.ocpack');
    Route::POST('/pack/open', [ocPackController::class, "openPack"])->name('admin.pack.open');
    Route::POST('/pack/close', [ocPackController::class, "closePack"])->name('admin.pack.close');


    Route::get('/dashboard', [DashboardController::class, "index"])->name('admin.dashboard');
    // Dados

    Route::get('/financas', [CaixaController::class, "index"])->name('admin.financas');
    

    Route::get('/relatorio', [OrderController::class, "index"])->name('admin.relatorio');

    
    Route::get('/relatorio/descontinuado', [VendaController::class, "index"])->name('admin.relatorio.descontinuado');


    Route::get('/historico', [HistoricoController::class, "index"])->name('admin.historico');

    Route::POST('/investimento/adicionar', [InvestimentoController::class, "adicionar"])->name('admin.investimento.add');

    Route::POST('/investimento/remover', [InvestimentoController::class, "remover"])->name('admin.investimento.remove');


    Route::POST('/caixa/resgateifood', [CaixaController::class, "resgateIfood"])->name('admin.resgate.ifood');

    Route::delete('/financa/{id}', [FinancaController::class, "destroy"])->name('financa.destroy');

    // Produto
    Route::get('/load_prod_cat', [EntradaController::class, "load"])->name('load_prod_cat');

    Route::get('/produto/{id}/editar', [ProdutoController::class, "editar"])->name('admin.produto.editar');
    Route::delete('/produto/{id}', [ProdutoController::class, "destroy"])->name('produto.destroy');
    Route::put('/produto/{id}', [ProdutoController::class, "put"])->name('produto.editar');

    // Estoque
    //GET
    Route::get('/cadastrar', [ProdutoController::class, "index"])->name('admin.cadastrar');

    Route::get('/estoque', [EstoqueController::class, "index"])->name('admin.estoque');

    Route::get('/entrada', [EntradaController::class, "index"])->name('admin.entrada');


    //POST
    Route::POST('/entradaestoque', [EntradaController::class, "entradaProdutos"])->name('admin.entradaestoque');

    Route::POST('/cadastrarproduto', [ProdutoController::class, "store"])->name('admin.cadastrarProduto');

    // Venda
    Route::POST('/vender/ifood', [VendaController::class, "vendaIfood"])->name('admin.venda.ifood');

    Route::POST('/vender/loja', [VendaController::class, "vendaLoja"])->name('admin.venda.loja');


    Route::delete('/venda/{id}', [VendaController::class, "destroy"])->name('venda.destroy');

    // Clientes

    Route::get('/cliente', [ClienteController::class, "index"])->name('admin.cliente');

    Route::get('/clienteCadastro', [ClienteController::class, "cadastrar"])->name('admin.clienteCadastro');
    Route::post('/cliente/store', [ClienteController::class, "store"])->name('admin.cliente.store');
    Route::get('/cliente/{id}', [ClienteController::class, "show"])->name('admin.cliente.perfil');

    /////////////////////////////////////

    Route::get('/cadastrar', function () {
        return view('admin.cadastrar');
    })->name('admin.cadastrar');


    Route::get('/vender', function () {
        return view('admin.vender');
    })->name('admin.vender');

    Route::get('/venderIfood', function () {
        return view('admin.venderIfood');
    })->name('admin.venderIfood');
});
