<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caixa;
use App\Models\Financa;
use App\Models\Product;

class CaixaController extends Controller
{


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

    public static function saldo()
    {
        $caixa = new Caixa;
        $caixa = $caixa->all();

        return $caixa[0]->saldo;
    }


    public static function meta()
    {
        $caixa = new Caixa;
        $caixa = $caixa->all();

        return $caixa[2]->saldo;
    }


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

}
