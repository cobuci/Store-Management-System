<?php

namespace App\Http\Controllers;

use App\Models\Historico;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria;

class EntradaController extends Controller
{

    public function __construct(Categoria $categoria, Produto $produto)
    {
        $this->categoria = $categoria;
        $this->produto = $produto;
    }


    public function listarCat()
    {
    }

    public function index()
    {
        $categorias = $this->categoria
            ->orderBy('id', 'asc')
            ->get();
        $produtos = $this->produto
            ->where('id', '=', 0)
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.entrada', ['categorias' => $categorias, 'produtos' => $produtos]);
    }

    public function load(Request $request)
    {

        $dataForm = $request->all();

        $categoria_id = $dataForm['categoria'];

        $produtos = $this->produto
            ->where('id_categoria', '=', $categoria_id)
            ->orderBy('nome', 'asc')
            ->get();
        return view('admin.master.ajax', ['produtos' => $produtos]);
    }

    public function entradaProdutos(Request $request)
    {

        $produto = Produto::find($request->produto);

        $produto->quantidade += $request->quantidade;

        $custo = EntradaController::custoMedio($request->produto, $request->custo, $request->quantidade);

        $request->custo != 0 ? $produto->custo = $custo : null;


        $request->venda != null ? $produto->venda = $request->venda : null;
        $produto->validade = $request->validade;
        $produto->save();

        $valorRemovido = $request->quantidade * $request->custo;

        if ($produto->id_categoria == 9) {
            $valorRemovido = 0;
        } else {

            $valorRemovido = $request->quantidade * $request->custo;
        }

        FinancaController::adicionarCompra($request->produto, $valorRemovido, $request->quantidade);
        CaixaController::removerSaldo($valorRemovido);
        HistoricoController::adicionar("ENTRADA", "Compra de ($request->quantidade - $produto->nome )");

        return redirect('/estoque');
    }

    public static function custoMedio($id, $custo, $quantidadeEntrada)
    {

        $produto = Produto::find($id);

        $quantidadeFinal = $quantidadeEntrada + $produto->quantidade;

        if ($custo > 0) {
            $custoMedio = (($quantidadeEntrada * $custo) + ($produto->custo * $produto->quantidade)) / $quantidadeFinal;
            $produto->custo > 0 ? $custo = $custoMedio : null;
        } else {
            $custo = $produto->custo;
        }

        return $custo;
    }
}
