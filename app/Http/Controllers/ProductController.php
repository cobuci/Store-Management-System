<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreUpdateProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{


    public function index()
    {
        return view('admin.product_register');
    }



    public function put($id, StoreUpdateProduct $request)
    {
        $product = Product::find($id);

        $request = $request->all();

        $request['weight'] != null ? $request['weight'] = $request['weight'] . $request['weight_type'] :  $request['weight'] = $product->weight;


        $history = "Edição do Produto " . $request['name'] . " - " . $request['brand'] . " - (" . $product->weight . ")";

        HistoryController::adicionar("EDIÇÃO", $history);
        $product->update($request);
        return  redirect()->route('admin.estoque');
    }

    public function destroy($id)
    {
        if (!$produto = Product::find($id)) {
            return redirect()->route('admin.estoque');
        } else {
            $produto->delete();

            HistoryController::adicionar("APAGAR", "O Produto $produto->name -  $produto->weight - $produto->brand foi excluido ");

            return redirect()->route('admin.estoque');
        }
    }


    public static function listar()
    {
        $prod = new Product();
        return $prod->orderBy('name')->get();
    }


    public static function listarUltimos()
    {

        return Product::orderBy('id', 'desc')->take(5)->get();
    }

    public static function removerEstoque($id, $amount)
    {
        $produto = Product::find($id);
        $produto->amount -= $amount;
        $produto->save();
    }

    public static function adicionarEstoque($id, $amount)
    {
        $produto = Product::find($id);
        $produto->amount += $amount;
        $produto->save();
    }

    public function store(Request $request)
    {

        $request = $request->all();

        $request['weight'] = $request['weight'] . $request['weight_type'];

        Product::create($request);

        $history = "Cadastro do Produto " . $request['name'] . " - " . $request['brand'] . " - (" . $request['weight'] . ")";

        HistoryController::adicionar("CADASTRO", $history);
        return redirect('/estoque');
    }



    public static function findProduct($id)
    {
        return DB::table('products')
            ->where('id', '=', $id)
            ->get();
    }
}
