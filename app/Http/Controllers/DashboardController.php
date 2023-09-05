<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{

    public function index()
    {
        // Resgata o valor de quantos meses devera mostrar no grafico da dashboard
        $getMonths = json_decode(file_get_contents('../config/app_settings.json'));
        $monthsChart = $getMonths->monthsChart->value;

        return view('admin.dashboard', [
            'monthsChart' => $monthsChart
        ]);
    }

    // "Today" Fuctions

    // Retorna o dia da última venda, dado o número de dias a olhar para trás (o padrão é 1).
    public static function day()
    {
        $sales = DB::table('vendas')
            ->select(
                DB::raw('DAY(created_at) as day'),
            )
            ->orderBy('created_at', 'desc')
            ->get();

        count($sales) > 0 ? $sales = $sales[0]->day : $sales = 0;

        return $sales;
    }

    // Mostra o total em R$ vendido no ultimo dia registrado ,dado o número de dias a olhar para trás (o padrão é 1).
    public static function salesToday($date = 1)
    {
        $sales = DB::table('vendas')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(precoVenda) as capital'),
            )
            ->groupBy('date')
            ->get();

        if (count($sales) > 1) {
            $sales = $sales[count($sales) - $date];
            $sales = $sales->capital;
        } else if (count($sales) == 1) {
            $sales = $sales[0];
            $sales = $sales->capital;
        } else {
            $sales = 0;
        }

        return $sales;
    }

    // Mostra o custo total do que foi vendido em R$ no ultimo dia registrado
    public static function costToday($date = 1)
    {
        $custo = DB::table('vendas')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(custo) as custoVenda')
            )
            ->groupBy('date')
            ->get();

        if (count($custo) > 1) {
            $custo = $custo[count($custo) - $date];
            $custo = $custo->custoVenda;
        } else if (count($custo) == 1) {
            $custo = $custo[0];
            $custo = $custo->custoVenda;
        } else {
            return null;
        }

        return $custo;
    }

    // Retorna a média diaria do Mês
    public static function dailyAvg()
    {
        $revenue = DashboardController::salesMonth();
        $day = DashboardController::day();

        try {
            $average = $revenue / $day;
            $average = number_format($average, 2);
        } catch (\DivisionByZeroError $e) {
            $average = $revenue;
        }

        return $average;
    }

    // Calcula o lucro no ultimo dia registrado
    public static function profit($date = 1)
    {
        $cost = DashboardController::costToday($date);
        $sale =  DashboardController::salesToday($date);

        $profit = $sale - $cost;

        return $profit;
    }
    
    // Retorna o valor em % de vendas em relação ao dia anterior
    public static function percentDailySales()
    {
        $today = DashboardController::salesToday();
        $yesterday = DashboardController::salesToday(2);

        if ($yesterday) {
            $amount = $today - $yesterday;

            $amount = ($amount / abs($yesterday)) * 100;

            $amount = number_format($amount, 2);

            return $amount;
        } else {
            return 0;
        }
    }  

    ///////////////////////////////////////////
    // "Month" Fuctions

    // Retorna o mês da última venda, dado o número de meses a olhar para trás (o padrão é 1).
    public static function month($date = 1)
    {
        $sales = DB::table('vendas')
            ->select(
                DB::raw('count(id) as `data`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month, DAY(created_at) day')
            )
            ->groupBy('year', 'month')
            ->get();

        if (!empty($sales)) {
            $latestMonthData = $sales[count($sales) - $date];
            return $latestMonthData->month;
        } else {
            return null;
        }
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
    public static function salesMonth($date = 1)
    {

        $sales = DB::table('vendas')
            ->select(
                DB::raw('count(id) as `data`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month'),
                DB::raw('SUM(precoVenda) as capital')
            )
            ->groupBy('year', 'month')
            ->get();

        if (count($sales) > $date) {
            $sales = $sales[count($sales) - $date];
            $sales = $sales->capital;
        } elseif (count($sales) == 1) {
            $sales = $sales[0]->capital;
        } else {
            $sales = 0;
        }

        return $sales;
    }

    // Retorna o custo total no Mês informado
    public static function costMonth($date = 1)
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

        if (count($custo) > $date) {
            $custo = $custo[count($custo) - $date];
            $custo = $custo->custo;
        } elseif (count($custo) == 1) {
            $custo = $custo[0]->custo;
        } else {
            $custo = null;
        }

        return $custo;
    }

    // Retorna o Lucro do mês informado
    public static function profitMonth($date = 1)
    {
        $cost = DashboardController::costMonth($date);
        $sale =  DashboardController::salesMonth($date);

        $profit = $sale - $cost;

        return $profit;
    }

   // Retorna o valor em % de vendas em relação ao Mês anterior
    public static function porcentagemVendasMensais()
    {
        $currentMonth = DashboardController::salesMonth(1);
        $previousMonth = DashboardController::salesMonth(2);

        if ($previousMonth) {
            $amount = $currentMonth - $previousMonth;
            $amount = ($amount / abs($previousMonth)) * 100;
            $amount = number_format($amount, 2);

            return $amount;
        } else {
            return null;
        }
    }

    // Meta

    // Retorna o valor da meta atual
    public static function monthGoal()
    {
        $goal = CaixaController::meta();

        return $goal;
    }

    // Retorna a porcentagem atual da meta
    public static function goalPercentage()
    {
        $current = DashboardController::salesMonth(1);
        $goal =  CaixaController::meta();

        try {
            $percentage = ($current / $goal) * 100;
        } catch (\DivisionByZeroError $e) {
            $percentage = 0;
        }

        return number_format($percentage, 2);
    }
}
