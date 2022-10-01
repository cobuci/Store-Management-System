<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendaProduto;
use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Produto;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class VendaController extends Controller
{
    use WithPagination;
    public function index(Venda $venda)
    {

        $venda = Venda::latest("id")->paginate(10)->onEachSide(1);
      

        return view('admin.relatorioDescontinuado', [
            'venda' => $venda,
            
        ]);
    }


    public function vendaIfood(VendaProduto $request)
    {

        $produto = Produto::find($request->produto);

        $produto->quantidade -= $request->quantidade;

        $valorTotal = floatval($request->quantidade * $produto->venda);
        CaixaController::adicionarIfood($valorTotal);
        HistoricoController::adicionar("IFOOD", "VENDA de ($request->quantidade - $produto->nome)");
        FinancaController::adicionarVenda($valorTotal, $valorTotal, $request->quantidade);

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
        $venda->id_produto = $produto->id;

        $venda->save();

        $produto->quantidade == 0 ? $produto->custo = 0 : null;
        $produto->save();

        return redirect('/relatorio');
    }

    public function vendaLoja(VendaProduto $request)
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
        $venda->formaPagamento = $request->pagamento;           ///////////////
        $venda->created_at = \Carbon\Carbon::now()->toDateTimeString();
        $request->cliente != "null" ? $venda->id_cliente = $cliente->id : null;
        $request->cliente != "null" ? $venda->nomeCliente = $cliente->nome : null;
        $venda->quantidade = $request->quantidade;
        $venda->precoVenda = $valorTotal;       ///////////////
        $venda->precoUnidade = $produto->custo;
        $venda->id_produto = $produto->id;
        $venda->marca = $produto->marca;
        $venda->desconto = $request->desconto; ///////////////

        $venda->save();

        $produto->quantidade == 0 ? $produto->custo = 0 : null;
        $produto->save();

        return redirect('/relatorio');
    }

    public static function vendaDescontinuada($order_id, $desconto, $formaPagamento, $cliente, $bonificacao, $idProduto, $quantidade)
    {

        $produto = Produto::find($idProduto);

        $cliente = Cliente::find($cliente);


        $venda = new Venda();

        // CLIENTE
        $cliente != null ? $venda->id_cliente = $cliente->id : null;
        $cliente != null ? $venda->nomeCliente = $cliente->nome : null;



        // Tratamento de valores
        $valorVenda = $quantidade * $produto->venda;
        $valorVenda -= $desconto;

        $taxa = 1;
        $formaPagamento == "Credito" ? $taxa = 0.9501 : null;
        $formaPagamento == "Debito" ? $taxa = 0.98 : null;

        $bonificacao == 1 ? $valorVenda = 0 : null;
        $valorVenda = floatval($valorVenda) * $taxa;


        $venda->created_at = \Carbon\Carbon::now()->toDateTimeString();
        /// PAGAMENTO

        $venda->custo = $quantidade * $produto->custo;
        $venda->desconto = $desconto;
        $venda->formaPagamento = $formaPagamento;
        $venda->precoVenda = $valorVenda;


        // Produto        
        $venda->produto = $produto->nome;
        $venda->precoUnidade = $produto->custo;
        $venda->id_produto = $produto->id;
        $venda->marca = $produto->marca;
        $venda->quantidade = $quantidade;

        $venda->order_id = $order_id;

        $venda->save();
    }




    public function destroy($id)
    {

        $venda = Venda::find($id);

        ProdutoController::adicionarEstoque($venda->id_produto, $venda->quantidade);
        $venda->formaPagamento != "Ifood" ?  CaixaController::removerSaldo($venda->precoVenda) : CaixaController::removerIfood($venda->precoVenda);
        HistoricoController::adicionar("CANCELAMENTO", "Cancelamento da venda #$venda->id");
        FinancaController::cancelarVenda($venda->id, $venda->precoVenda);

        $venda->delete();

        return redirect('/relatorio');
    }
}
