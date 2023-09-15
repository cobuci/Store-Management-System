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
        return  redirect()->route('admin.inventory');
    }

    public function destroy($id)
    {
        if ($product = Product::find($id)) {
            $product->delete();
            HistoryController::adicionar("APAGAR", "O Produto $product->name -  $product->weight - $product->brand foi excluido ");
        }
        return redirect()->route('admin.inventory');
    }


    public static function listar()
    {
        $prod = new Product();
        return $prod->orderBy('name')->get();
    }

    public static function removerEstoque($id, $amount)
    {
        $produto = Product::find($id);
        $produto->amount -= $amount;
        $produto->save();
    }

    public static function addStock($id, $amount)
    {
        $product = Product::find($id);
        $product->amount += $amount;
        $product->save();
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