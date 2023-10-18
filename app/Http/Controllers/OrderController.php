<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function __construct(Product $produto, Order $order)
    {
    }

    public static function destroy($id)
    {

        $sale = Sale::find($id);

        // Retornar o produto ao estoque
        $order = OrderController::findOrder($sale->order_id);
        $order = json_decode($order, true);
        foreach ($order as $key => $value) {

            ProductController::addStock($value['product_id'], $value['amount']);
        }
        // Retirar saldo

        CashierController::withdrawBalance($sale->price);

        Order::where('order_id', $sale->order_id)->delete();

        HistoryController::addToHistory("CANCELAMENTO", "Cancelamento da venda #$sale->id");
        FinanceController::cancelSale($sale->id, $sale->price);

        $sale->delete();
        return back();
    }

    public static function findOrder($id)
    {
        return DB::table('orders')
            ->where('order_id', '=', $id)
            ->get();
    }

    public static function newOrder($params)
    {
        $params = get_object_vars($params);

        $product = Product::find($params['product_id']);

        $params['unit_cost'] = $product->cost;
        $params['product_name'] = $product->name;
        $params['product_brand'] = $product->brand;
        $params['unit_price'] = $product->sale;
        $params['weight'] = $product->weight;


        Order::create($params);

    }

}
