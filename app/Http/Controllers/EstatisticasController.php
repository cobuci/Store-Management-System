<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstatisticasController extends Controller
{
    public function index(Request $request)
    {

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $dados = $this->productType($startDate, $endDate);

        $totalCusto =  $this->custoTotal($startDate, $endDate);
        $totalVenda =  $this->vendaTotal($startDate, $endDate);
        $totalLucro = $totalVenda->value('total') -  $totalCusto->value('total');

        if (empty($startDate)) {
            $startDate = '2020-01-01';
        }
        if (empty($endDate)) {
            $endDate = Carbon::now()->toDateString();
        }
        return view('admin.estatisticas', [
            'dados' => $dados,
            'startDate' => Carbon::parse($startDate),
            'endDate' => Carbon::parse($endDate),
            'totalCusto' => $totalCusto->value('total'),
            'totalVenda' => $totalVenda->value('total'),
            'totalLucro' => $totalLucro,
        ]);
    }



    public static function productType($startDate, $endDate)
    {
        if (empty($startDate)) {
            $startDate = '2020-01-01';
        }
        if (empty($endDate)) {
            $endDate = Carbon::now()->toDateString();
        }
        $vendas = DB::table('vendas')
            ->select(
                'id_produto',
                DB::raw('sum(quantidade) as total_vendas'),
                DB::raw('sum(custo) as total_custo'),
                DB::raw('sum(precoVenda) as total_venda'),
            )
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->groupBy('id_produto')
            ->get();
        return array($vendas);
    }

    public static function custoTotal($startDate, $endDate)
    {
        if (empty($startDate)) {
            $startDate = '2020-01-01';
        }
        if (empty($endDate)) {
            $endDate = Carbon::now()->toDateString();
        }
        $custo = DB::table('vendas')
            ->select(

                DB::raw('sum(custo) as total')
            )
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();
        return ($custo);
    }

    
    public static function vendaTotal($startDate, $endDate)
    {
        if (empty($startDate)) {
            $startDate = '2020-01-01';
        }
        if (empty($endDate)) {
            $endDate = Carbon::now()->toDateString();
        }
        $venda = DB::table('vendas')
            ->select(

                DB::raw('sum(precoVenda) as total')
            )
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();
        return ($venda);
    }
}
