<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {

        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));
        $allowed_categories = $getConfig->alertCategory->categoryId;


        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $data = $this->productType($startDate, $endDate);

        $cost_total =  $this->custoTotal($startDate, $endDate);
        $sale_total =  $this->vendaTotal($startDate, $endDate);
        $profit_total = $sale_total->value('total') -  $cost_total->value('total');

        if (empty($startDate)) {
            $startDate = '2020-01-01';
        }
        if (empty($endDate)) {
            $endDate = Carbon::now()->toDateString();
        }

        return view('admin.statistics', [
            'data' => $data,
            'startDate' => Carbon::parse($startDate),
            'endDate' => Carbon::parse($endDate),
            'cost_total' => $cost_total->value('total'),
            'sale_total' => $sale_total->value('total'),
            'profit_total' => $profit_total,
            'allowed_categories' => $allowed_categories,
        ]);
    }

    public static function estoqueAlerta($qtdVendida, $dias)
    {
        $dias == 0 && $dias = 1;
        return round((($qtdVendida / $dias) * 14));
    }


    public static function productType($startDate, $endDate)
    {
        if (empty($startDate)) {
            $startDate = '2020-01-01';
        }
        if (empty($endDate)) {
            $endDate = Carbon::now()->toDateString();
        }
        $vendas = DB::table('orders')
            ->join('sales', 'orders.order_id', '=', 'sales.order_id') // Junção entre as tabelas orders e sales
            ->select(
                'orders.product_id',
                DB::raw('sum(orders.amount) as total_vendas'),
                DB::raw('sum(orders.unit_cost  * orders.amount) as total_custo'),
                DB::raw('sum(orders.unit_price * orders.amount) as total_venda')
            )
            ->whereDate('sales.created_at', '>=', $startDate) // Use sales.created_at em vez de orders.created_at
            ->whereDate('sales.created_at', '<=', $endDate)   // Use sales.created_at em vez de orders.created_at
            ->groupBy('orders.product_id')
            ->orderBy('total_vendas', 'desc')
            ->get();

        return $vendas;
    }

    public function custoTotal($startDate, $endDate)
    {
        if (empty($startDate)) {
            $startDate = '2020-01-01';
        }
        if (empty($endDate)) {
            $endDate = Carbon::now()->toDateString();
        }
        $custo = DB::table('sales')
            ->select(
                DB::raw('sum(cost) as total')
            )
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();
        return ($custo);
    }


    public function vendaTotal($startDate, $endDate)
    {
        if (empty($startDate)) {
            $startDate = '2020-01-01';
        }
        if (empty($endDate)) {
            $endDate = Carbon::now()->toDateString();
        }
        $venda = DB::table('sales')
            ->select(

                DB::raw('sum(price) as total')
            )
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();
        return ($venda);
    }
}
