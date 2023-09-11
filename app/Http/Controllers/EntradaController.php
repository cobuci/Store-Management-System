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

        return view('admin.product_add', ['categorias' => $categorias, 'produtos' => $produtos]);
    }

    public function load(Request $request)
    {

        $request = $request->all();

        $categoria_id = $request['categoria'];

        $produtos = $this->produto
            ->where('category_id', '=', $categoria_id)
            ->orderBy('name', 'asc')
            ->get();
        return view('admin.master.ajax', ['produtos' => $produtos]);
    }

    public function entradaProdutos(Request $request)
    {

        $product = Produto::find($request->product);

        $product->amount += $request->amount;

        $cost = EntradaController::custoMedio($request->product, $request->cost, $request->amount);

        $request->cost != 0 ? $product->cost = $cost : null;


        $request->sale != null ? $product->sale = $request->sale : null;
        $product->expiration_date = $request->expiration_date;
        $product->save();

        $valorRemovido = $request->amount * $request->cost;

        if ($product->category_id == 9) {
            $valorRemovido = 0;
        } else {

            $valorRemovido = $request->amount * $request->cost;
        }

        FinancaController::adicionarCompra($request->product, $valorRemovido, $request->amount);
        CaixaController::removerSaldo($valorRemovido);
        HistoricoController::adicionar("ENTRADA", "Compra de ($request->amount - $product->name )");

        return redirect('/estoque');
    }

    public static function custoMedio($id, $cost, $quantidadeEntrada)
    {

        $produto = Produto::find($id);

        $quantidadeFinal = $quantidadeEntrada + $produto->amount;

        if ($cost > 0) {
            $custoMedio = (($quantidadeEntrada * $cost) + ($produto->cost * $produto->amount)) / $quantidadeFinal;
            $produto->cost > 0 ? $cost = $custoMedio : null;
        } else {
            $cost = $produto->cost;
        }

        return $cost;
    }
}
