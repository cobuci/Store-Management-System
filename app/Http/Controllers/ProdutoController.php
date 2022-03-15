<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use App\Http\Requests\StoreUpdateProduto;

class ProdutoController extends Controller
{


    public function index()
    {
        return view('admin.cadastrar');
    }

    public function editar($id)
    {

        $produto = Produto::find($id);
        return view('admin.editar_produto', compact('produto'));
    }



    public function put($id, StoreUpdateProduto $request)
    {
        $produto = Produto::find($id);

        $data = $request->only('nome', 'marca', 'quantidade', 'validade', 'custo', 'venda');
        $request->peso != null ? $data['peso'] = $request->peso . $request->tipoPeso : null;

        $data['id_categoria'] = $request->categoria;
        $produto->update($data);

        return view('admin.estoque');
    }

    public function destroy($id)
    {
        if (!$produto = Produto::find($id)) {
            return redirect()->route('admin.estoque');
        } else {
            $produto->delete();
            return redirect()->route('admin.estoque');
        }
    }



    public static function listar()
    {
        $prod = new Produto();
        $produto = $prod->all();
        return $produto;
    }


    public static function removerEstoque($id, $quantidade)
    {
        $produto = Produto::find($id);
        $produto->quantidade -= $quantidade;
        $produto->save();
    }

    public static function adicionarEstoque($id, $quantidade)
    {
        $produto = Produto::find($id);
        $produto->quantidade += $quantidade;
        $produto->save();
    }

    public function store(StoreUpdateProduto $request)
    {

        $produto = new Produto();

        $produto->nome = $request->nome;
        $produto->marca = $request->marca;
        $produto->peso = $request->peso . $request->tipoPeso;
        $produto->id_categoria = $request->categoria;
        $produto->save();

        HistoricoController::adicionar("CADASTRO", "Cadastro do Produto $request->nome - $request->marca -($request->peso.$request->tipoPeso) ");
        return redirect('/estoque');
    }
}
