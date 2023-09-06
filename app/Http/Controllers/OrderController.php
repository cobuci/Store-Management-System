<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Order;
use App\Models\Produto;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class OrderController extends Controller
{

    public function __construct(Produto $produto, Order $order)
    {
    }

    public function index(Sale $sale)
    {

        $sale = Sale::latest("id")->where('status_pagamento', 'LIKE', '1')->paginate(10)->onEachSide(1);
        $unconfirmedSale = Sale::latest("id")->where('status_pagamento', 'LIKE', '0')->get();

        $modalArray = $unconfirmedSale->concat($sale);

        $total = 0;

        foreach ($unconfirmedSale as $item) {
            if ($item->status_pagamento == 0) {
                $total = $total + $item->precoVenda;
            }
        }

        return view('admin.relatorio', [
            'venda' => $sale,
            'unconfirmedSale' => $unconfirmedSale,
            'total' => $total,
            'modalArray' => $modalArray,
        ]);
    }



    public function filtrarRelatorio(Request $request)
    {
        $search = $request->input('search');
        $dados = DB::table('sales')
            ->where('nomeCliente', 'LIKE', '%' . $search . '%')
            ->where('status_pagamento', '=', '0')
            ->orderByDesc('created_at')
            ->get();

        if ($request->ajax()) {
            return view('admin.clientePartialRelatorio', compact('dados'));
        }

        return view('admin.clientePartialRelatorio', compact('dados'));
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

        $idVenda = uniqid('',true);

        $paramsOrder = new stdClass();

        foreach ($produtos as $key => $productId) {

            $produto = Produto::find($productId);
            $qtdEntrada = $quantidade[$key];

            $custo += $produto->custo * $qtdEntrada;
            $valorVenda += $produto->venda * $qtdEntrada;
            
            $paramsOrder->orderId = $idVenda;
            $paramsOrder->productId = $productId;
            $paramsOrder->quantity = $qtdEntrada;

            ProdutoController::removerEstoque($productId,  $qtdEntrada);
            OrderController::newOrder($paramsOrder);
        }
        $params = new stdClass();

        $params->custo = $custo;
        $params->valorVenda = $valorVenda;
        $params->desconto = $desconto;
        $params->formaPagamento = $formaPagamento;
        $params->clienteId = $cliente;
        $params->idVenda = $idVenda;
        $params->bonificacao = $bonificacao;

        OrderController::newSale($params);

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

        CaixaController::removerSaldo($sale->precoVenda);

        Order::where('order_id', $sale->order_id)->delete();
       
        HistoricoController::adicionar("CANCELAMENTO", "Cancelamento da venda #$sale->id");
        FinancaController::cancelarVenda($sale->id, $sale->precoVenda);

        $sale->delete();
        return redirect('/relatorio');
    }


    public static function changeStatusOrder($id)
    {
        $sale = Sale::find($id);

        $sale->status_pagamento = 1;
        $sale->save();
        return redirect('/relatorio');
    }


    public static function newSale($params)
    {

        $params = get_object_vars($params);
        
        $cliente = Cliente::find($params['clienteId']);

        $sale = new Sale();

        // CLIENTE
        $cliente != null ? $sale->id_cliente = $cliente->id : null;
        $cliente != null ? $sale->nomeCliente = $cliente->nome : null;

        // Tratamento de valores
        $valorVenda = $params['valorVenda'] -= $params['desconto'];

        $taxa = 1;

        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));

        $creditFee = $getConfig->cardFee->credit;
        $debitFee = $getConfig->cardFee->debit;

        $params['formaPagamento'] == "Credito" ? $taxa = $creditFee : null;
        $params['formaPagamento'] == "Debito" ? $taxa = $debitFee : null;

        $params['bonificacao'] == 1 ? $valorVenda = 0 : null;
        $valorVenda = floatval($valorVenda) * $taxa;
        /// PAGAMENTO

        $sale->custo = $params['custo'];

        $sale->order_id = $params['idVenda'];
        $sale->desconto = $params['desconto'];
        $sale->formaPagamento = $params['formaPagamento'];
        $sale->precoVenda = $valorVenda;


        /// DATA
        $sale->created_at = \Carbon\Carbon::now()->toDateTimeString();


        $sale->save();

        CaixaController::adicionarSaldo($valorVenda);
        FinancaController::adicionarVenda($valorVenda, $params['idVenda']);
        HistoricoController::adicionar("VENDA", "Nova venda realizada ");
    }


    public function newOrder($params)
    {

        $params = get_object_vars($params);

        $orderId = $params['orderId'];
        $productId = $params['productId'];
        $quantity = $params['quantity'];
      


        $produto = Produto::find($productId);
        $order = new Order();

        $order->order_id = $orderId;
        $order->quantidade = $quantity;

        $order->product_id = $productId;
        $order->custoUnidade = $produto->custo;
        $order->produto = $produto->nome;
        $order->marca = $produto->marca;
        $order->precoUnidade = $produto->venda;
        $order->peso = $produto->peso;

        $order->save();
    }
}
