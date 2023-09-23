<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use App\Models\Product;
use App\Models\Venda;

class FinanceController extends Controller
{
    public static function addSale($value)
    {
        $finance = new Finance();

        $finance->value = $value;
        $finance->description = 'Nova Venda realizada';
        $finance->type = "txn";
        $finance->date = \Carbon\Carbon::now()->toDateTimeString();
        $finance->save();
    }

    public static function cancelarVenda($id, $valor)
    {

        $finance = new Finance();
        $descriptor = "Cancelamento da Venda #$id";

        $finance->valor = $valor;
        $finance->descricao = $descriptor;
        $finance->tipo = "CANCELAMENTO";


        $finance->save();
    }

    public static function adicionarCompra($product, $sale, $amount)
    {
        $product = Product::find($product);
        $finance = new Finance();

        $descriptor = "Compra de ($amount - $product->name - $product->brand - $product->weight)";
        $finance->id_produto = $product->id;
        $finance->quantidade = $amount;
        $finance->valor = $sale;
        $finance->descricao = $descriptor;
        $finance->tipo = "SAIDA";

        $finance->save();
    }

    public static function adicionarInvestimento($valor, $descricao, $data)
    {

        $financa = new Finance();

        $financa->descricao = $descricao;
        $financa->tipo = "INVESTIMENTO";
        $financa->valor = $valor;
        $financa->data = $data;
        $financa->save();
    }

    public static function resgateInvestimento($valor, $descricao, $data, $tipo = "RESGATE")
    {

        $financa = new Finance();

        $financa->descricao = $descricao;
        $financa->tipo = $tipo;
        $financa->valor = $valor;
        $financa->data = $data;
        $financa->save();
    }

    public function destroy($id)
    {
        $financa = Finance::find($id);

        if ($financa->tipo == "SAIDA") {
            if ($financa->id_produto != 0) {
                ProductController::removeStock($financa->id_produto, $financa->quantidade);
            }
            CaixaController::addBalance($financa->valor);
            $financa->delete();
        }
        if ($financa->tipo == "RESGATE") {

            CaixaController::addBalance($financa->valor);
            CaixaController::removerInvestimento($financa->valor);

            $financa->delete();
        }

        if ($financa->tipo == "INVESTIMENTO") {

            CaixaController::removerSaldo($financa->valor);
            CaixaController::adicionarInvestimento($financa->valor);
            $financa->delete();
        }



        return redirect('/financas');
    }
}
