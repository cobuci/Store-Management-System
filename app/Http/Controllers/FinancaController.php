<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Financa;
use App\Models\Produto;
use App\Models\Venda;

class FinancaController extends Controller
{
    public static function adicionarVenda($produto, $valor, $quantidade)
    {
        $produto = Produto::find($produto);
        $financa = new Financa();

        $descricao = "Venda de ($quantidade - $produto->nome - $produto->marca - $produto->peso)";

        $financa->valor = $valor;
        $financa->descricao = $descricao;
        $financa->tipo = "ENTRADA";

        $financa->save();
    }

    public static function cancelarVenda($id, $valor)
    {
      
        $financa = new Financa();
        $descricao = "Cancelamento da Venda #$id";

        $financa->valor = $valor;
        $financa->descricao = $descricao;
        $financa->tipo = "CANCELAMENTO";

        $financa->save();
    }

    public static function adicionarCompra($produto, $valor, $quantidade)
    {
        $produto = Produto::find($produto);
        $financa = new Financa();

        $descricao = "Compra de ($quantidade - $produto->nome - $produto->marca - $produto->peso)";
        $financa->id_produto = $produto->id;
        $financa->quantidade = $quantidade;
        $financa->valor = $valor;
        $financa->descricao = $descricao;
        $financa->tipo = "SAIDA";

        $financa->save();
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
                ProdutoController::removerEstoque($financa->id_produto, $financa->quantidade);
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

        if ($financa->tipo == "IFOOD") {

            CaixaController::removerSaldo($financa->valor);
            CaixaController::adicionarIfood($financa->valor);
            $financa->delete();
        }

        return redirect('/financas');
    }
}
