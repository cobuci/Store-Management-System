<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {

        return view('admin.dashboard');
    }



    public static function salesToday($data = 1)
    {

        $vendas = DB::table('vendas')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as vendas_hoje'),
                DB::raw('SUM(precoVenda) as capital')
            )
            ->groupBy('date')
            ->get();

        $vendas = json_decode($vendas, true);
        if (sizeof($vendas) > 1) {
            $vendas = $vendas[sizeof($vendas) - $data];
            $vendas = $vendas['capital'];

            return $vendas;
        } else {
            return null;
        }
    }

    public static function salesMonth($data = 1)
    {

        $vendas = DB::table('vendas')
            ->select(
                DB::raw('count(id) as `data`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month'),
                DB::raw('SUM(precoVenda) as capital')
            )
            ->groupby('year', 'month')
            ->get();

        $vendas = json_decode($vendas, true);
        if (sizeof($vendas) > 1) {
            $vendas = $vendas[sizeof($vendas) - $data];
            $vendas = $vendas['capital'];

            return ($vendas);
        } else {
            return null;
        }
    }

    public static function porcentagemVendasDiaria()
    {

        $hoje = DashboardController::salesToday();
        $ontem = DashboardController::salesToday(2);

        if ($ontem) {
            $valor = $hoje - $ontem;

            $valor = ($valor / abs($ontem)) * 100;

            $valor = number_format($valor, 2);

            return $valor;
        } else {
            return 0;
        }
    }

    public static function ultimoDiaVenda()
    {

        $vendas = DB::table('vendas')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as vendas_hoje')
            )
            ->groupBy('date')
            ->get();
        $vendas = json_decode($vendas, true);

        if (sizeof($vendas) > 1) {
            $vendas = $vendas[sizeof($vendas) - 1];
            $vendas = date("d/m", strtotime($vendas['date']));
        } else {
            return null;
        }
        return ($vendas);
    }


    public static function porcentagemVendasMensais()
    {

        $atual = DashboardController::salesMonth(1);
        $anterior = DashboardController::salesMonth(2);

        if ($anterior) {
            $valor = $atual - $anterior;

            $valor = ($valor / abs($anterior)) * 100;

            $valor = number_format($valor, 2);

            return $valor;
        } else {
            return null;
        }
    }

    public static function monthGoal()
    {
        $atual = DashboardController::salesMonth(1);
        $anterior = DashboardController::salesMonth(2);

        $goal =  number_format($anterior * 1.33, 2);

        return $goal;
    }

    public static function porcentagemGoal()
    {
        $atual = DashboardController::salesMonth(1);
        $anterior = DashboardController::salesMonth(2);

        $goal =  $anterior * 1.33;
        $porcentagem = ($atual / $goal) * 100;

        return number_format($porcentagem,2);
    }
}
