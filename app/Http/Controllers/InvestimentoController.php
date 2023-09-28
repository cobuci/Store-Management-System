<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Investimento;

class InvestimentoController extends Controller
{

    public static function adicionar(Request $request)
    {

        $investimento = new Investimento();

        $investimento->valorInvestimento += $request->valor;
        $investimento->descricao = $request->descricao;
        $investimento->data = $request->data;

        $investimento->save();

        CashierController::removerInvestimento($request->valor);
        CashierController::addBalance($request->valor);
        FinanceController::adicionarInvestimento($request->valor, $request->descricao, $request->data);
        return redirect('/financas');
    }

    public static function remover(Request $request)
    {

        $investimento = new Investimento();

        $investimento->valorInvestimento -= $request->valor;
        $investimento->descricao = $request->descricao;
        $investimento->data = $request->data;

        $investimento->save();

        CashierController::withdrawBalance($request->valor);
        CashierController::adicionarInvestimento($request->valor);
        FinanceController::resgateInvestimento($request->valor, $request->descricao, $request->data);

        return redirect('/financas');
    }
}
