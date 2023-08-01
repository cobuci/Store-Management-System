<?php

namespace App\Http\Controllers;

use App\Models\Caixa;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(Settings $settings)
    {
        $settings = $settings->all();


        $mesesGrafico = $settings[1]->valor;


        return view('admin.dashboard', [
            'mesesGrafico' => $mesesGrafico

        ]);
    }




    public static function salesToday($data = 1)
    {

        $vendas = DB::table('vendas')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(precoVenda) as capital'),
            )
            ->groupBy('date')
            ->get();

        $vendas = json_decode($vendas, true);
        if (sizeof($vendas) > 1) {
            $vendas = $vendas[sizeof($vendas) - $data];
            $vendas = $vendas['capital'];

            return $vendas;
        } else if (sizeof($vendas) == 1) {
            $vendas = $vendas[0];
            $vendas = $vendas['capital'];

            return $vendas;
        } else {
            return $vendas = 0;
        }
    }


    public static function costToday($data = 1)
    {

        $custo = DB::table('vendas')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(custo) as custoVenda')
            )
            ->groupBy('date')
            ->get();

        $custo = json_decode($custo, true);
        if (sizeof($custo) > 1) {
            $custo = $custo[sizeof($custo) - $data];
            $custo = $custo['custoVenda'];

            return $custo;
        } else if (sizeof($custo) == 1) {
            $custo = $custo[0];
            $custo = $custo['custoVenda'];

            return $custo;
        } else {
            return null;
        }
    }


    public static function profit($data = 1)
    {

        $custo = DashboardController::costToday($data);
        $venda =  DashboardController::salesToday($data);

        $lucro = $venda - $custo;

        return $lucro;
    }



    public static function dia($data = 1)
    {

        $vendas = DB::table('vendas')
            ->select(
                DB::raw('count(id) as `data`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month, DAY(created_at) day'),

            )
            ->groupBy('year', 'month', 'day')
            ->get();

        $day = json_decode($vendas, true);
        if (sizeof($vendas) > 1) {
            $day = $day[sizeof($vendas) - $data];
            $day = $day['day'];

            return  $day;
        } else if (sizeof($vendas) == 1) {
            $day = $day[0];
            $day = $day['day'];

            return  $day;
        } else {
            return null;
        }
    }

    public static function month($data = 1)
    {

        $vendas = DB::table('vendas')
            ->select(
                DB::raw('count(id) as `data`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month, DAY(created_at) day'),

            )
            ->groupBy('year', 'month')
            ->get();

        $month = json_decode($vendas, true);
        if (sizeof($vendas) > 1) {
            $month = $month[sizeof($vendas) - $data];
            $month = $month['month'];

            return  $month;
        } else {
            return null;
        }
    }



    public static function verificarMes($mes)
    {

        if ($mes == 1) {
            return "Janeiro";
        } else if ($mes == 2) {
            return "Fevereiro";
        } else if ($mes == 3) {
            return "Março";
        } else if ($mes == 4) {
            return "Abril";
        } else if ($mes == 5) {
            return "Maio";
        } else if ($mes == 6) {
            return "Junho";
        } else if ($mes == 7) {
            return "Julho";
        } else if ($mes == 8) {
            return "Agosto";
        } else if ($mes == 9) {
            return "Setembro";
        } else if ($mes == 10) {
            return "Outubro";
        } else if ($mes == 11) {
            return "Novembro";
        } else if ($mes == 12) {
            return "Dezembro";
        }
    }


    public static function dailyAvg($data = 1)
    {
        $revenue = DashboardController::salesMonth();
        $day = DashboardController::dia(1);

        try {
            $average = $revenue / $day;
            $average = number_format($average, 2);
        } catch (\DivisionByZeroError $e) {
            $average = $revenue;
        }


        return $average;
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
            ->groupBy('year', 'month')
            ->get();

        $vendas = json_decode($vendas, true);
        if (sizeof($vendas) > 1) {
            $vendas = $vendas[sizeof($vendas) - $data];
            $vendas = $vendas['capital'];

            return ($vendas);
        } else if (sizeof($vendas) == 1) {
            $vendas = $vendas[0];
            $vendas = $vendas['capital'];

            return ($vendas);
        } else {
            return $vendas = 0;
        }
    }

    public static function costMonth($data = 1)
    {

        $custo = DB::table('vendas')
            ->select(
                DB::raw('count(id) as `data`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month'),
                DB::raw('SUM(custo) as custo')
            )
            ->groupBy('year', 'month')
            ->get();

        $custo = json_decode($custo, true);
        if (sizeof($custo) > 1) {
            $custo = $custo[sizeof($custo) - $data];
            $custo = $custo['custo'];

            return ($custo);
        } else if (sizeof($custo) == 1) {
            $custo = $custo[0];
            $custo = $custo['custo'];

            return ($custo);
        } else {
            return null;
        }
    }


    public static function profitMonth($data = 1)
    {

        $custo = DashboardController::costMonth($data);
        $venda =  DashboardController::salesMonth($data);

        $lucro = $venda - $custo;

        return $lucro;
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
        $goal = CaixaController::meta();

        return $goal;
    }

    public static function porcentagemGoal()
    {
        $atual = DashboardController::salesMonth(1);
        $goal =  CaixaController::meta();

        try {
            $porcentagem = ($atual / $goal) * 100;
        } catch (\DivisionByZeroError $e) {
            $porcentagem = 0;
        }



        return number_format($porcentagem, 2);
    }
}
