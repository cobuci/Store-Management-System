<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historico;

class HistoricoController extends Controller
{
    public function index()
    {
        return view('admin.historico');
    }

    public static function listarHistorico()
    {
        $historico = Historico::latest("id")->paginate(10);
        return $historico;
    }

    public static function adicionar($tipo, $descricao)
    {

        $historico = new Historico();

        $historico->tipo = $tipo;
        $historico->descricao = $descricao;       

        $historico->save();
    }
}
