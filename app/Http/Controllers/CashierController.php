<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cashier;
use App\Models\Finance;
use App\Models\Product;

class CashierController extends Controller
{


    public function index(Cashier $caixa)
    {
        $caixa = $caixa->all();

        $saldo = $caixa[0]->saldo;
        $investimento = $caixa[1]->saldo;
        $meta = $caixa[2]->meta;

        $financas = Finance::latest("id")->paginate(10)->onEachSide(1);

        return view('admin.financas', [
            'saldo' => $saldo,
            'investimento' => $investimento,
            'financas' => $financas,
            'meta' => $meta,
        ]);
    }

    public static function balance()
    {
        $caixa = new Cashier;
        $caixa = $caixa->all();

        return $caixa[0]->balance;
    }


    public static function goal()
    {
        $caixa = new Cashier;
        $caixa = $caixa->all();

        return $caixa[2]->balance;
    }


    // Remover Saldos
    public static function withdrawBalance($value)
    {
        $cashier = Cashier::find(1);
        $cashier->balance -= $value;
        $cashier->save();
    }

    public static function removerInvestimento($valorEntrada)
    {
        $cashier = Cashier::find(2);
        $cashier->balance -= $valorEntrada;
        $cashier->save();
    }

    public static function addBalance($valorEntrada)
    {
        $cashier = Cashier::find(1);
        $cashier->balance += $valorEntrada;
        $cashier->save();
    }
    public static function adicionarInvestimento($valorEntrada)
    {

        $cashier = Cashier::find(2);
        $cashier->balance += $valorEntrada;
        $cashier->save();
    }
    public static function definirMeta(Request $request)
    {
        $cashier = Cashier::find(3);
        $cashier->balance = $request->valor;
        $cashier->save();
    }

}
