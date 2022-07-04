<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Order;
use App\Models\Produto;
use App\Models\Sale;
use App\Models\Venda;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function __construct(Produto $produto, Order $order)
    {

        $this->produto = $produto;
        $this->order = $order;
    }

    public function index(Sale $venda)
    {

        $venda = Sale::latest("id")->paginate(10)->onEachSide(1);
        $unconfirmedSale = Sale::latest("id")->get();

        $total = 0;
        foreach ($unconfirmedSale as $item) {
            if ($item->status_pagamento == 0) {
                $total = $total + $item->precoVenda;
            }
        }



        return view('admin.relatorio', [
            'venda' => $venda,
            'unconfirmedSale' => $unconfirmedSale,
            'total' => $total,
        ]);
    }


    public static function findOrder($id)
    {

        $order = DB::table('orders')
            ->where('order_id', '=', $id)
            ->get();

        return $order;
    }

    public function store(Request $request)
    {

        $produtos = [];
        $quantidade = [];

        $qtdItens = $request->quantidadeProdutos;


        $arrayRequest = $request->all();
        $desconto = $request->desconto;
        $formaPagamento = $request->pagamento;
        $cliente = $request->cliente;
        $bonificacao = $request->bonificacao;

        for ($i = 0; $i < $qtdItens; $i++) {
            array_push($produtos, $arrayRequest['produto' . ($i + 1)]);
            array_push($quantidade, $arrayRequest['quantidade' . ($i + 1)]);
        }


        $custo = 0;
        $valorVenda = 0;

        $idVenda = uniqid();



        foreach ($produtos as $key => $productId) {

            $produto = Produto::find($productId);
            $qtdEntrada = $quantidade[$key];

            $custo += $produto->custo * $qtdEntrada;
            $valorVenda += $produto->venda * $qtdEntrada;

            ProdutoController::removerEstoque($productId,  $qtdEntrada);
            OrderController::newOrder($idVenda, $productId, $qtdEntrada);

            VendaController::vendaDescontinuada($idVenda, $desconto, $formaPagamento, $cliente, $bonificacao, $productId, $qtdEntrada);
        }

        OrderController::newSale($custo, $valorVenda, $desconto, $formaPagamento, $cliente, $idVenda, $bonificacao);

        return redirect('/relatorio');
    }


    public function destroy($id)
    {

        $sale = Sale::find($id);


        // Retornar o produto ao estoque
        $order = OrderController::findOrder($sale->order_id);
        $order = json_decode($order, true);
        foreach ($order as $key => $value) {

            ProdutoController::adicionarEstoque($value['product_id'], $value['quantidade']);
        }



        // Retirar saldo
        $sale->formaPagamento != "Ifood" ?
            CaixaController::removerSaldo($sale->precoVenda) :
            CaixaController::removerIfood($sale->precoVenda);

        Order::where('order_id', $sale->order_id)->delete();
        Venda::where('order_id', $sale->order_id)->delete();
        HistoricoController::adicionar("CANCELAMENTO", "Cancelamento da venda #$sale->id");
        FinancaController::cancelarVenda($sale->id, $sale->precoVenda);

        $sale->delete();
        return redirect('/estoque');
    }

    public function deleteVenda($id)
    {
        $venda = Venda::find($id);
        $venda->delete();
    }


    public static function changeStatusOrder($id)
    {
        $sale = Sale::find($id);

        $sale->status_pagamento = 1;
        $sale->save();
        return redirect('/relatorio');
    }


    public static function newSale($custo, $valorVenda, $desconto = 0, $formaPagamento, $clienteId, $idVenda, $bonificacao)
    {


        $cliente = Cliente::find($clienteId);

        $venda = new Sale();

        // CLIENTE
        $cliente != null ? $venda->id_cliente = $cliente->id : null;
        $cliente != null ? $venda->nomeCliente = $cliente->nome : null;

        // Tratamento de valores
        $valorVenda -= $desconto;

        $taxa = 1;
        $formaPagamento == "Credito" ? $taxa = 0.9501 : null;
        $formaPagamento == "Debito" ? $taxa = 0.98 : null;

        $bonificacao == 1 ? $valorVenda = 0 : null;
        $valorVenda = floatval($valorVenda) * $taxa;
        /// PAGAMENTO

        $venda->custo = $custo;

        $venda->order_id = $idVenda;
        $venda->desconto = $desconto;
        $venda->formaPagamento = $formaPagamento;
        $venda->precoVenda = $valorVenda;


        /// DATA
        $venda->created_at = \Carbon\Carbon::now()->toDateTimeString();


        $venda->save();

        CaixaController::adicionarSaldo($valorVenda);
        FinancaController::adicionarVenda($valorVenda, $idVenda);
        HistoricoController::adicionar("VENDA", "Nova venda realizada ");
    }


    public function newOrder($orderId, $productId, $quantity)
    {


        $produto = Produto::find($productId);
        $order = new Order();

        $order->order_id = $orderId;
        $order->quantidade = $quantity;

        $order->product_id = $productId;

        $order->produto = $produto->nome;
        $order->marca = $produto->marca;
        $order->precoUnidade = $produto->venda;
        $order->peso = $produto->peso;

        $order->save();
    }
}
