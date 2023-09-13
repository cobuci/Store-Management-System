<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Financa;
use App\Models\Product;
use App\Models\Venda;

class FinancaController extends Controller
{
    public static function adicionarVenda($valor, $idVenda)
    {

        $finance = new Financa();

        $descriptor = "Nova Venda";

        $finance->valor = $valor;
        $finance->descricao = $descriptor;
        $finance->tipo = "ENTRADA";
        $finance->data = \Carbon\Carbon::now()->toDateTimeString();
        $finance->save();
    }

    public static function cancelarVenda($id, $valor)
    {

        $finance = new Financa();
        $descriptor = "Cancelamento da Venda #$id";

        $finance->valor = $valor;
        $finance->descricao = $descriptor;
        $finance->tipo = "CANCELAMENTO";


        $finance->save();
    }

    public static function adicionarCompra($product, $sale, $amount)
    {
        $product = Product::find($product);
        $finance = new Financa();

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

        $financa = new Financa();

        $financa->descricao = $descricao;
        $financa->tipo = "INVESTIMENTO";
        $financa->valor = $valor;
        $financa->data = $data;
        $financa->save();
    }

    public static function resgateInvestimento($valor, $descricao, $data, $tipo = "RESGATE")
    {

        $financa = new Financa();

        $financa->descricao = $descricao;
        $financa->tipo = $tipo;
        $financa->valor = $valor;
        $financa->data = $data;
        $financa->save();
    }

    public function destroy($id)
    {
        $financa = Financa::find($id);

        if ($financa->tipo == "SAIDA") {
            if ($financa->id_produto != 0) {
                ProductController::removerEstoque($financa->id_produto, $financa->quantidade);
            }
            CaixaController::adicionarSaldo($financa->valor);
            $financa->delete();
        }
        if ($financa->tipo == "RESGATE") {

            CaixaController::adicionarSaldo($financa->valor);
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
