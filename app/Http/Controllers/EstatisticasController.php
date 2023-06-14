<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstatisticasController extends Controller
{
    public function index()
    {

        $dados = $this->productType();


        return view('admin.estatisticas', [
            'dados' => $dados,
        ]);
    }



    public static function productType($data = 1)
    {
        $vendas = DB::table('vendas')
            ->select(
                'id_produto',
                DB::raw('sum(quantidade) as total_vendas'),
                DB::raw('sum(custo) as total_custo'),
                DB::raw('sum(precoVenda) as total_venda'),
            )
            ->groupBy('id_produto')
            ->get();


        return array($vendas);
    }
}
