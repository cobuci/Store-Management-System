<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Http\Controllers\CashierController;
use App\Models\Cashier;
use App\Models\Sale;
use DivisionByZeroError;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;

class Dashboard extends Component
{
    use Actions;

    public array $sales = [
        'today' => '',
        'yesterday' => '',
        'month' => '',
        'lastMonth' => '',
    ];

    public array $profit = [
        'today' => '',
        'yesterday' => '',
        'month' => '',
        'lastMonth' => '',
    ];

    public array $percent = [
        'today' => '',
        'month' => '',
        'goal' => '',
    ];

    public array $data = [
        'balance' => '',
        'dailyAverage' => '',
        'goal' => '',
        'month' => '',
        'monthsChart' => '',
    ];

    public function changeGoal(): void
    {
        $goalFind = Cashier::find(3);
        $goalFind->balance = $this->data['goal'];
        $goalFind->save();

        $this->notification()->success(
            title: 'Valor da meta atualizado com sucesso!',
        );
    }

    public function goalDialog(): void
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

    public function mount(): void
    {
        $this->sales = [
            'today' =>  $this->getSalesIncomeForLastDays(),
            'yesterday' => $this->getSalesIncomeForLastDays(1),
            'month' => $this->getSalesIncomeForLastMonth(),
            'lastMonth' => $this->getSalesIncomeForLastMonth(1),
        ];

        $this->profit = [
            'today' => $this->getDailyProfit(),
            'yesterday' => $this->getDailyProfit(1),
            'month' => $this->getMonthProfit(),
            'lastMonth' => $this->getMonthProfit(1),
        ];

        $this->percent = [
            'today' => $this->percentDailySales(),
            'month' => $this->percentMonthSales(),

        ];

        $this->data = [
            'balance' => CashierController::balance(),
            'dailyAverage' => $this->getDailyAverage(),
            'month' => $this->checkMonth($this->getLastSaleMonth()),
            'monthsChart' => config('pages.dashboard.monthsChart'),
        ];
    }

    public function render(): View|Application
    {
        $this->data['goal'] = CashierController::goal();
        $this->percent['goal'] = $this->calculateGoalMonthPercentage();

        return view('admin.dashboard');
    }

    public function checkMonth($month): string
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

        return $namesOfMonths[$month] ?? "Indefinido";
    }

    public function getLastSaleMonth(Int $date = 0)
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

        return $sales[$date]->month ?? 0;
    }

    public function getSalesIncomeForLastDays(Int $date = 0)
    {
        $sales = DB::table('sales')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(price) as total_price'),
            )
            ->groupBy('date')
            ->orderBy('created_at', 'desc')
            ->get();

        return $sales[$date]->total_price ?? 0;
    }

    public function getSalesIncomeForLastMonth(Int $date = 0)
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
        return $sales[$date]->total_price ?? 0;
    }

    public function percentDailySales(): string
    {
        $today = Dashboard::getSalesIncomeForLastDays();
        $yesterday = floatval(Dashboard::getSalesIncomeForLastDays(1));
        if ($yesterday) {
            $amount = $today - $yesterday;

            $amount = ($amount / abs($yesterday)) * 100;

            return number_format($amount, 2);
        } else {
            return "0";
        }
    }

    public function percentMonthSales(): string
    {
        $current_month = Dashboard::getSalesIncomeForLastMonth();
        $previous_month = floatval(Dashboard::getSalesIncomeForLastMonth(1));
        if ($previous_month) {
            $amount = $current_month - $previous_month;
            $amount = ($amount / abs($previous_month)) * 100;
            return number_format($amount, 2);
        } else {
            return "0";
        }
    }

    public function calculateGoalMonthPercentage(): string
    {
        $sales = floatval($this->sales['month']);
        try {
            $goal = floatval($this->data['goal']);

            $percent = ($sales / $goal) * 100;

        } catch (DivisionByZeroError) {
            $percent = 0;
        }

        return number_format($percent, 2);
    }

    public function getDailyAverage()
    {
        $revenue = $this->sales['month'];
        $day = $this->getLastSaleDay();

        try {
            $average = $revenue / $day;
            $average = number_format($average, 2);
        } catch (DivisionByZeroError) {
            $average = $revenue;
        }

        return $average;
    }

    public function getLastSaleDay(Int $date = 0)
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

    public function getMonthProfit(Int $date = 0)
    {
        $monthCost = $this->getSalesCostForLastMonth($date);
        $monthIncome = $this->getSalesIncomeForLastMonth($date);
        return $monthIncome - $monthCost;
    }

    public function getSalesCostForLastMonth(Int $date = 0)
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
        return $sales[$date]->cost ?? null;
    }

    public function getDailyProfit(Int $date = 0)
    {
        $dayCost = $this->getSalesCostForLastDays($date);
        $dayIncome = $this->getSalesIncomeForLastDays($date);
        return $dayIncome - $dayCost;
    }

    public static function getSalesCostForLastDays(Int $date = 0)
    {
        $sales = DB::table('sales')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(cost) as cost')
            )
            ->groupBy('date')
            ->orderBy('created_at', 'desc')
            ->get();

        return $sales[$date]->cost ?? 0;
    }
}
