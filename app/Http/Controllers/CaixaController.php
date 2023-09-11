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
        $meta = $caixa[2]->meta;

        $financas = Financa::latest("id")->paginate(10)->onEachSide(1);


        return view('admin.financas', [
            'saldo' => $saldo,
            'investimento' => $investimento,
            'financas' => $financas,
            'meta' => $meta,
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
        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));

        $skipCat = $getConfig->stockSkipCategories;


        $prod = new Produto();
        $produto = $prod->all();
        $valorCusto = 0;

        foreach ($produto as $produto) {
            if (!in_array($produto->category_id, $skipCat)) {
                $valorCusto += ($produto->cost * $produto->amount);
            }
        }
        return number_format($valorCusto, 2);
    }

    public static function valorVenda()
    {
        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));

        $skipCat = $getConfig->stockSkipCategories;

    

        $prod = new Produto();
        $produto = $prod->all();
        $valorVenda = 0;


        foreach ($produto as $produto) {
            if (!in_array($produto->category_id, $skipCat)) {
                $valorVenda += ($produto->sale * $produto->amount);
            }
        }
        return number_format($valorVenda, 2);
    }

    public static function valorLucro()
    {
        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));

        $skipCat = $getConfig->stockSkipCategories;


        $prod = new Produto();
        $produto = $prod->all();
        $valorVenda = 0;
        $valorCusto = 0;

        foreach ($produto as $produto) {
            if (!in_array($produto->category_id, $skipCat)) {
                $valorCusto += ($produto->cost * $produto->amount);
                $valorVenda += ($produto->sale * $produto->amount);
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


    public static function meta()
    {
        $caixa = new Caixa;
        $caixa = $caixa->all();

        $meta = $caixa[2]->saldo;

        return $meta;
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



    public static function definirMeta(Request $request)
    {
        $saldo = Caixa::find(4);
        $saldo->saldo = $request->valor;
        $saldo->save();

        return redirect('/dashboard');
    }

    //////////////////////////////////////////////////////

}
