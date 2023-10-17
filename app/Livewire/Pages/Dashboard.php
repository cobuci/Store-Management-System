<?php

namespace App\Livewire\Pages;

use App\Http\Controllers\CashierController;
use App\Models\Cashier;
use App\Models\Sale;
use DivisionByZeroError;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;

class Dashboard extends Component
{
    use Actions;

    public string $monthsChart = '';
    public string $goal = '';
    public string $month = '';
    public string $salesToday = '';
    public string $balance = '';
    public string $percentDailySales = '';
    public string $salesMonth = '';
    public string $salesLastMonth = '';
    public string $salesYesterday = '';
    public string $percentMonthSales = '';
    public string $goalPercent = '';
    public string $dailyMonthAverage = '';

    public string $monthProfit = '';
    public string $dayProfit = '';
    public string $lastMonthProfit = '';
    public string $lastDayProfit = '';

    public function changeGoal()
    {
        $goalFind = Cashier::find(3);
        $goalFind->balance = $this->goal;
        $goalFind->save();
        $this->notification()->success(
            title: 'Valor da meta atualizado com sucesso!',
        );
    }

    public function goalDialog()
    {
        $this->dialog()->id('goalDialog')->confirm([
            'icon' => 'document-report',
            'accept' => [
                'label' => 'Definir',
                'color' => 'positive',
                'method' => 'changeGoal',
            ],
            'reject' => [
                'label' => 'Cancelar',
                'color' => 'negative',
            ],
        ]);
    }




    public function render()
    {
        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));
        $this->monthsChart = $getConfig->monthsChart->value;
        $this->goal = CashierController::goal();
        $this->balance = CashierController::balance();
        $this->month = $this->checkMonth($this->getLastSaleMonth());
        $this->salesToday = $this->getSalesIncomeForLastDays();
        $this->salesMonth = $this->getSalesIncomeForLastMonth();
        $this->salesYesterday = $this->getSalesIncomeForLastDays(1);
        $this->percentDailySales = $this->percentDailySales();
        $this->percentMonthSales = $this->percentMonthSales();
        $this->salesLastMonth = $this->getSalesIncomeForLastMonth(1);
        $this->goalPercent = $this->calculateGoalMonthPercentage();
        $this->dailyMonthAverage = $this->getDailyMonthAverage();
        $this->monthProfit = $this->getMonthProfit();
        $this->dayProfit = $this->getDailyProfit();
        $this->lastMonthProfit = $this->getMonthProfit(1);
        $this->lastDayProfit = $this->getDailyProfit(1);

        return view('admin.dashboard');
    }

    public function checkMonth($month)
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

    public function getLastSaleMonth($date = 0)
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

    public function getSalesIncomeForLastDays($date = 0)
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

    public function getSalesIncomeForLastMonth($date = 0)
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
        return $sales[$date]->total_price ?? $result = 0;
    }

    public function percentDailySales()
    {
        $today = Dashboard::getSalesIncomeForLastDays();
        $yesterday = Dashboard::getSalesIncomeForLastDays(1);
        if ($yesterday) {
            $amount = $today - $yesterday;

            $amount = ($amount / abs($yesterday)) * 100;

            return number_format($amount, 2);
        } else {
            return 0;
        }
    }

    public function percentMonthSales()
    {
        $current_month = Dashboard::getSalesIncomeForLastMonth();
        $previous_month = Dashboard::getSalesIncomeForLastMonth(1);
        if ($previous_month) {
            $amount = $current_month - $previous_month;
            $amount = ($amount / abs($previous_month)) * 100;
            return number_format($amount, 2);
        } else {
            return 0;
        }
    }

    public function calculateGoalMonthPercentage(): string
    {
        $percent = 0;
        try {
            $percent = ($this->salesMonth / $this->goal) * 100;
        } catch (DivisionByZeroError $e) {
            $percentage = 0;
        }

        return number_format($percent, 2);
    }

    public function getDailyMonthAverage()
    {
        $revenue = $this->salesMonth;
        $day = $this->getLastSaleDay();

        try {
            $average = $revenue / $day;
            $average = number_format($average, 2);
        } catch (DivisionByZeroError $e) {
            $average = $revenue;
        }

        return $average;
    }

    public function getLastSaleDay($date = 0)
    {
        $date = max(0, $date);
        $sales = Sale::selectRaw('DAY(created_at) as day')
            ->orderByDesc('created_at')
            ->get();
        if ($sales->isEmpty()) {
            return 0;
        }
        if ($date >= $sales->count()) {
            return $sales->last()->day;
        }
        return $sales[$date]->day;
    }

    public function getMonthProfit($date = 0)
    {
        $monthCost = $this->getSalesCostForLastMonth($date);
        $monthIncome = $this->getSalesIncomeForLastMonth($date);
        return $monthIncome - $monthCost;
    }

    public function getSalesCostForLastMonth($date = 0)
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
        return $sales[$date]->cost ?? $result = null;
    }

    public function getDailyProfit($date = 0)
    {
        $dayCost = $this->getSalesCostForLastDays($date);
        $dayIncome = $this->getSalesIncomeForLastDays($date);
        return $dayIncome - $dayCost;
    }

    public static function getSalesCostForLastDays($date = 0)
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
}
