<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Produto;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    public function index(Venda $venda)
    {
        
        $venda = Venda::latest("id")->simplepaginate(10);

        return view('admin.relatorio', [
            'venda' => $venda,
        ]);
    }


    public function vendaIfood(Request $request)
    {

        $produto = Produto::find($request->produto);

        $produto->quantidade -= $request->quantidade;

        $valorTotal = floatval($request->valorTotal);
        CaixaController::adicionarIfood($valorTotal);
        HistoricoController::adicionar("IFOOD", "VENDA de ($request->quantidade - $produto->nome)");
        FinancaController::adicionarVenda($request->produto, $valorTotal, $request->quantidade);

        $venda = new Venda();

        $venda->produto = $produto->nome;
        $venda->custo = $request->quantidade * $produto->custo;
        $venda->formaPagamento = "Ifood";
        $venda->created_at = \Carbon\Carbon::now()->toDateTimeString();
        $venda->quantidade = $request->quantidade;
        $venda->precoVenda = $valorTotal;
        $venda->precoUnidade = $produto->custo;
        $venda->desconto = $request->desconto;
        $venda->marca = $produto->marca;

        $venda->save();

        $produto->quantidade == 0 ? $produto->custo = 0 : null;
        $produto->save();

        return redirect('/relatorio');
    }

    public function vendaLoja(Request $request)
    {

        $produto = Produto::find($request->produto);

        $cliente = Cliente::find($request->cliente);

        $produto->quantidade -= $request->quantidade;

        $taxa = 1;
        $request->pagamento == "Credito" ? $taxa = 0.9501 : null;
        $request->pagamento == "Debito" ? $taxa = 0.98 : null;
        $request->bonificacao == 1 ? $request->valorTotal = 0 : null;


        $valorTotal = floatval($request->valorTotal) * $taxa;


        CaixaController::adicionarSaldo($valorTotal);
        HistoricoController::adicionar("VENDA", "VENDA de ($request->quantidade - $produto->nome)");
        FinancaController::adicionarVenda($request->produto, $valorTotal, $request->quantidade);


        $venda = new Venda();

        $venda->produto = $produto->nome;
        $venda->custo = $request->quantidade * $produto->custo;
        $venda->formaPagamento = $request->pagamento;
        $venda->created_at = \Carbon\Carbon::now()->toDateTimeString();;
        $request->cliente != "null" ? $venda->id_cliente = $cliente->id : null;
        $request->cliente != "null" ? $venda->nomeCliente = $cliente->nome : null;
        $venda->quantidade = $request->quantidade;
        $venda->precoVenda = $valorTotal;
        $venda->precoUnidade = $produto->custo;
        $venda->id_produto = $produto->id;
        $venda->marca = $produto->marca;
        $venda->desconto = $request->desconto;

        $venda->save();

        $produto->quantidade == 0 ? $produto->custo = 0 : null;
        $produto->save();

        return redirect('/relatorio');
    }



    public function destroy($id)
    {

        $venda = Venda::find($id);

        ProdutoController::adicionarEstoque($venda->id_produto, $venda->quantidade);
        CaixaController::removerSaldo($venda->precoVenda);
        FinancaController::cancelarVenda($venda->id, $venda->precoVenda);

        $venda->delete();

       return redirect('/relatorio');
    }
}
