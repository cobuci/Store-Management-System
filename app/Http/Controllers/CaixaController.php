<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Caixa;
use App\Models\Financa;
use App\Models\Produto;
use Livewire\WithPagination;

class CaixaController extends Controller
{
use WithPagination;
    public function index(Caixa $caixa)
    {
        $caixa = $caixa->all();

        $saldo = $caixa[0]->saldo;
        $investimento = $caixa[1]->saldo;
        $ifood = $caixa[2]->saldo;

        $financas = Financa::latest("id")->paginate(10);


        

        return view('admin.financas', [
            'saldo' => $saldo,
            'investimento' => $investimento,
            'ifood' => $ifood,
            'financas' => $financas,
        ]);
    }

    public static function calcularLucro($precoVenda, $custoVenda)
    {
        if ($precoVenda > 0 && $custoVenda > 0) {
            $lucro = $precoVenda - $custoVenda;
            $porcentagemLucro = $lucro / $precoVenda;
            $porcentagemLucro = $porcentagemLucro * 100;

            $porcentagemLucro > 0 ? $operador = "+" : $operador = "";

            $porcentagemLucro = number_format($porcentagemLucro, 1);

            $lucro = "R$ " .  number_format($lucro, 2) . " ($operador $porcentagemLucro%)";
            return $lucro;
        } else {
            return "-";
        }
    }

    public static function valorCusto()
    {
        $prod = new Produto();
        $produto = $prod->all();
        $valorCusto = 0;

        foreach ($produto as $produto) {
            if ($produto->id_categoria != 9) {
                $valorCusto += ($produto->custo * $produto->quantidade);
            }
        }
        return number_format($valorCusto, 2);
    }

    public static function valorVenda()
    {

        $prod = new Produto();
        $produto = $prod->all();
        $valorVenda = 0;

        foreach ($produto as $produto) {
            if ($produto->id_categoria != 9) {
                $valorVenda += ($produto->venda * $produto->quantidade);
            }
        }
        return number_format($valorVenda, 2);
    }

    public static function valorLucro()
    {

        $prod = new Produto();
        $produto = $prod->all();
        $valorVenda = 0;
        $valorCusto = 0;

        foreach ($produto as $produto) {
            if ($produto->id_categoria != 9) {
                $valorCusto += ($produto->custo * $produto->quantidade);
                $valorVenda += ($produto->venda * $produto->quantidade);
            }
        }

        $lucro = ($valorVenda - $valorCusto);
        return number_format($lucro, 2);
    }


    public static function saldo()
    {
        $caixa = new Caixa;
        $caixa = $caixa->all();

        $saldo = $caixa[0]->saldo;

        return $saldo;
    }
    ///////////////////////////////////////////////////////

    // Remover Saldos
    public static function removerSaldo($valorEntrada)
    {
        $saldo = Caixa::find(1);
        $saldo->saldo -= $valorEntrada;
        $saldo->save();
    }

    public static function removerInvestimento($valorEntrada)
    {
        $saldo = Caixa::find(2);
        $saldo->saldo -= $valorEntrada;
        $saldo->save();
    }

    public static function removerIfood($valorEntrada)
    {
        $saldo = Caixa::find(3);
        $saldo->saldo -= $valorEntrada;
        $saldo->save();
    }
    ///////////////////////////////////////////////////////

    // Adicionar Saldos
    public static function adicionarSaldo($valorEntrada)
    {

        $saldo = Caixa::find(1);
        $saldo->saldo += $valorEntrada;
        $saldo->save();
    }

    public static function adicionarInvestimento($valorEntrada)
    {

        $saldo = Caixa::find(2);
        $saldo->saldo += $valorEntrada;
        $saldo->save();
    }

    public static function adicionarIfood($valorEntrada)
    {
        $saldo = Caixa::find(3);
        $saldo->saldo += $valorEntrada;
        $saldo->save();
    }

    //////////////////////////////////////////////////////
    public static function resgateIfood(Request $request)
    {
        CaixaController::removerIfood($request->valor);
        CaixaController::adicionarSaldo($request->valor);

        HistoricoController::adicionar("RESGATE", "Resgate de R$ $request->valor");
        FinancaController::resgateInvestimento($request->valor, "Resgate Ifood", \Carbon\Carbon::now()->toDateTimeString(),"IFOOD");

        return redirect('/financas');
    }
}
