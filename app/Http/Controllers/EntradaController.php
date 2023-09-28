<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class EntradaController extends Controller
{

    public function __construct(Category $category, Product $products)
    {
        $this->category = $category;
        $this->product = $products;
    }


    public function listarCat()
    {
    }

    public function index()
    {
        $categories = $this->category
            ->orderBy('id')
            ->get();
        $products = $this->product
            ->where('id', '=', 0)
            ->orderBy('id')
            ->get();

        return view('admin.product_add', ['categories' => $categories, 'products' => $products]);
    }

    public function load(Request $request)
    {
        $request = $request->all();

        $categoria_id = $request['categoria'];

        $produtos = $this->product
            ->where('category_id', '=', $categoria_id)
            ->orderBy('name')
            ->get();
        return view('admin.master.ajax', ['produtos' => $produtos]);
    }

    public function entradaProdutos(Request $request)
    {

        $product = Product::find($request->product);

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

        FinanceController::addProductInventory($request->product, $valorRemovido, $request->amount);
        CashierController::withdrawBalance($valorRemovido);
        HistoryController::addToHistory("ENTRADA", "Compra de ($request->amount - $product->name )");

        return redirect()->route('admin.inventory');
    }

    public static function custoMedio($id, $cost, $quantidadeEntrada)
    {

        $product = Product::find($id);

        $final_amount = $quantidadeEntrada + $product->amount;

        if ($cost > 0) {
            $cost_average = (($quantidadeEntrada * $cost) + ($product->cost * $product->amount)) / $final_amount;
            $product->cost > 0 ? $cost = $cost_average : null;
        } else {
            $cost = $product->cost;
        }

        return $cost;
    }
}
