<?php

namespace App\Http\Controllers;

use DivisionByZeroError;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{

    public function index()
    {
        // Resgata o valor de quantos meses devera mostrar no grafico da dashboard
        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));
        $monthsChart = $getConfig->monthsChart->value;

        // Meta
        $goal = CaixaController::meta();


        return view('admin.dashboard', [
            'monthsChart' => $monthsChart,
            'goal' => $goal
        ]);
    }

    // "Today" Fuctions

    // Retorna o dia da última venda, dado o número de dias a olhar para trás (o padrão é 1).
    public static function day($date = 0)
    {
        $sales = DB::table('sales')
            ->select(
                DB::raw('DAY(created_at) as day'),
            )
            ->orderBy('created_at', 'desc')
            ->get();

        return $sales[$date]->day ?? $sales = 0;
    }

    // Mostra o total em R$ vendido no ultimo dia registrado ,dado o número de dias a olhar para trás (o padrão é 0).
    public static function salesToday($date = 0)
    {
        $sales = DB::table('sales')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(price) as total_price'),
            )
            ->groupBy('date')
            ->orderBy('created_at', 'desc')
            ->get();

        return $sales[$date]->total_price ?? $sales = 0;
    }

    // Mostra o custo total do que foi vendido em R$ no ultimo dia registrado
    public static function costToday($date = 0)
    {
        $sales = DB::table('sales')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(cost) as cost')
            )
            ->groupBy('date')
            ->orderBy('created_at', 'desc')
            ->get();

        return $sales[$date]->cost ?? $sales = 0;
    }

    // Retorna a média diaria do Mês
    public static function dailyAvg()
    {
        $revenue = DashboardController::salesMonth();
        $day = DashboardController::day();

        try {
            $average = $revenue / $day;
            $average = number_format($average, 2);
        } catch (DivisionByZeroError $e) {
            $average = $revenue;
        }

        return $average;
    }

    // Calcula o lucro no ultimo dia registrado
    public static function profit($date = 0)
    {
        $cost = DashboardController::costToday($date);
        $sale =  DashboardController::salesToday($date);

        return $sale - $cost;
    }

    // Retorna o valor em % de vendas em relação ao dia anterior
    public static function percentDailySales()
    {
        $today = DashboardController::salesToday();
        $yesterday = DashboardController::salesToday(1);

        if ($yesterday) {
            $amount = $today - $yesterday;

            $amount = ($amount / abs($yesterday)) * 100;

            return number_format($amount, 2);
        } else {
            return 0;
        }
    }

    ///////////////////////////////////////////
    // "Month" Fuctions

    // Retorna o mês da última venda, dado o número de meses a olhar para trás (o padrão é 0).
    public static function month($date = 0)
    {
        $sales = DB::table('sales')
            ->select(
                DB::raw('count(id) as `data`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month, DAY(created_at) day')
            )
            ->groupBy('year', 'month')
            ->orderBy('created_at', 'desc')
            ->get();

        return $sales[$date]->month ?? $sales = 0;
    }

    // Retorna o nome do Mês de acordo com o valor informado
    public static function checkMonth($month)
    {
        $namesOfMonths = [
            1 => "Janeiro",
            2 => "Fevereiro",
            3 => "Março",
            4 => "Abril",
            5 => "Maio",
            6 => "Junho",
            7 => "Julho",
            8 => "Agosto",
            9 => "Setembro",
            10 => "Outubro",
            11 => "Novembro",
            12 => "Dezembro",
        ];

        return $namesOfMonths[$month] ?? 0;
    }

    // Retorna o total vendido no Mês informado
    public static function salesMonth($date = 0)
    {
        $sales = DB::table('sales')
            ->select(
                DB::raw('count(id) as `data`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month'),
                DB::raw('SUM(price) as total_price')
            )
            ->groupBy('year', 'month')
            ->orderBy('id', 'desc')
            ->get();
        return $sales[$date]->total_price ?? $result = null;
    }

    // Retorna o custo total no Mês informado
    public static function costMonth($date = 0)
    {
        $sales = DB::table('sales')
            ->select(
                DB::raw('count(id) as `data`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month'),
                DB::raw('SUM(cost) as cost')
            )
            ->groupBy('year', 'month')
            ->orderBy('created_at', 'desc')
            ->get();


        return $sales[$date]->cost ?? $sales = 0;
    }

    // Retorna o Lucro do mês informado
    public static function profitMonth($date = 0)
    {
        $cost = DashboardController::costMonth($date);
        $sale =  DashboardController::salesMonth($date);

        return $sale - $cost;
    }

    // Retorna o valor em % de vendas em relação ao Mês anterior
    public static function percentageSalesMonthly()
    {
        $currentMonth = DashboardController::salesMonth();
        $previousMonth = DashboardController::salesMonth(1);

        if ($previousMonth) {
            $amount = $currentMonth - $previousMonth;
            $amount = ($amount / abs($previousMonth)) * 100;
            return number_format($amount, 2);
        } else {
            return null;
        }
    }

    // Meta

    // Retorna a porcentagem atual da meta
    public static function goalPercentage()
    {
        $current = DashboardController::salesMonth();
        $goal =  CaixaController::meta();

        try {
            $percentage = ($current / $goal) * 100;
        } catch (DivisionByZeroError $e) {
            $percentage = 0;
        }

        return number_format($percentage, 2);
    }
}
