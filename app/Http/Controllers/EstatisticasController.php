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


        return view('admin.estatisticas', [
            'dados' => $dados,
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
}
