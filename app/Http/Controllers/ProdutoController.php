<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Requests\StoreUpdateProduto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{


    public function index()
    {
        return view('admin.product_register');
    }



    public function put($id, StoreUpdateProduto $request)
    {
        $produto = Produto::find($id);

        $request = $request->all();

        $request['weight'] != null ? $request['weight'] = $request['weight'] . $request['weight_type'] :  $request['weight'] = $produto->weight;


        $history = "Edição do Produto " . $request['name'] . " - " . $request['brand'] . " - (" . $produto->weight . ")";

        HistoricoController::adicionar("EDIÇÃO", $history);
        $produto->update($request);
        return  redirect()->route('admin.estoque');
    }

    public function destroy($id)
    {
        if (!$produto = Produto::find($id)) {
            return redirect()->route('admin.estoque');
        } else {
            $produto->delete();

            HistoricoController::adicionar("APAGAR", "O Produto $produto->name -  $produto->weight - $produto->brand foi excluido ");

            return redirect()->route('admin.estoque');
        }
    }


    public static function listar()
    {
        $prod = new Produto();
        $produto = $prod->orderBy('name', 'asc')->get();
        return $produto;
    }


    public static function listarUltimos()
    {

        $produto = Produto::orderBy('id', 'desc')->take(5)->get();
        return $produto;
    }

    public static function removerEstoque($id, $amount)
    {
        $produto = Produto::find($id);
        $produto->amount -= $amount;
        $produto->save();
    }

    public static function adicionarEstoque($id, $amount)
    {
        $produto = Produto::find($id);
        $produto->amount += $amount;
        $produto->save();
    }

    public function store(Request $request)
    {

        $request = $request->all();

        $request['weight'] = $request['weight'] . $request['weight_type'];

        Produto::create($request);

        $history = "Cadastro do Produto " . $request['name'] . " - " . $request['brand'] . " - (" . $request['weight'] . ")";

        HistoricoController::adicionar("CADASTRO", $history);
        return redirect('/estoque');
    }



    public static function findProduct($id)
    {
        $produto = DB::table('produtos')
            ->where('id', '=', $id)
            ->get();

        return $produto;
    }
}
