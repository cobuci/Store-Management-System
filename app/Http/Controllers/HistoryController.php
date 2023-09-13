<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historico;

class HistoryController extends Controller
{
    public function index()
    {
        return view('admin.historico');
    }

    public static function listarHistorico()
    {
        return Historico::latest("id")->paginate(10)->onEachSide(1);
    }

    public static function adicionar($tipo, $descricao)
    {

        $historico = new Historico();

        $historico->tipo = $tipo;
        $historico->descricao = $descricao;

        $historico->save();
    }
}
