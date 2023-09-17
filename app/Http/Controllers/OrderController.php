<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class OrderController extends Controller
{

    public function __construct(Product $produto, Order $order)
    {
    }

    public function index(Sale $sale)
    {

        $sale = Sale::latest("id")->where('payment_status', 'LIKE', '1')->paginate(10)->onEachSide(1);
        $unconfirmedSale = Sale::latest("id")->where('payment_status', 'LIKE', '0')->get();

        $modalArray = $unconfirmedSale->concat($sale);

        $total = 0;

        foreach ($unconfirmedSale as $item) {
            if ($item->payment_status == 0) {
                $total = $total + $item->price;
            }
        }

        return view('admin.reports', [
            'venda' => $sale,
            'unconfirmedSale' => $unconfirmedSale,
            'total' => $total,
            'modalArray' => $modalArray,
        ]);
    }



    public function filterReport(Request $request)
    {
        $search = $request->input('search');
        $data = DB::table('sales')
            ->where('customer_name', 'LIKE', '%' . $search . '%')
            ->where('payment_status', '=', '0')
            ->orderByDesc('created_at')
            ->get();

        if ($request->ajax()) {
            return view('admin.reports_customer_filter', compact('data'));
        }

        return view('admin.reports_customer_filter', compact('data'));
    }



    public static function findOrder($id)
    {

        return DB::table('orders')
            ->where('order_id', '=', $id)
            ->get();
    }

    public function store(Request $request)
    {

        $products = [];
        $amount = [];
        $idSale = uniqid('', true);

        $n_items = $request->item_amount;

        $arrayRequest = $request->all();

        for ($i = 0; $i < $n_items; $i++) {
            $products[] = $arrayRequest['product' . ($i + 1)];
            $amount[] = $arrayRequest['amount' . ($i + 1)];
        }

        $cost = 0;
        $sale_price = 0;

        $paramsOrder = new stdClass();
        foreach ($products as $key => $product_id) {


            $product = Product::find($product_id);
            $amount_input = $amount[$key];

            $cost += $product->cost * $amount_input;
            $sale_price += $product->sale * $amount_input;

            $paramsOrder->order_id = $idSale;
            $paramsOrder->product_id = $product_id;
            $paramsOrder->amount = $amount_input;

            ProductController::removerEstoque($product_id,  $amount_input);
            OrderController::newOrder($paramsOrder);

        }

        $request['cost'] = $cost;
        $request['order_id'] = $idSale;
        $request['price'] = $sale_price;

        OrderController::newSale($request->all());

        return redirect()->route('admin.reports');
    }


    public function destroy($id)
    {

        $sale = Sale::find($id);


        // Retornar o produto ao estoque
        $order = OrderController::findOrder($sale->order_id);
        $order = json_decode($order, true);
        foreach ($order as $key => $value) {

            ProductController::addStock($value['product_id'], $value['amount']);
        }
        // Retirar saldo

        CaixaController::removerSaldo($sale->price);

        Order::where('order_id', $sale->order_id)->delete();

        HistoryController::adicionar("CANCELAMENTO", "Cancelamento da venda #$sale->id");
        FinancaController::cancelarVenda($sale->id, $sale->price);

        $sale->delete();
        return back();
    }


    public static function changeStatusOrder($id)
    {
        $sale = Sale::find($id);

        $sale->payment_status = 1;
        $sale->save();
        return back();
    }


    public static function newSale($params)
    {

        $customer = Customer::find($params['customer_id']);

        //CLIENTE
        $params['customer_id'] != "null" ? $params['customer_id'] = $customer->id : null;
        $params['customer_id']  != "null" ? $params['customer_name'] = $customer->name : null;

        // Tratamento de valores
        $valorVenda = $params['price'] -= $params['discount'];
        $fee = 1;
        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));

        $creditFee = $getConfig->cardFee->credit;
        $debitFee = $getConfig->cardFee->debit;

        $params['payment_method'] == "Credito" ? $fee = $creditFee : null;
        $params['payment_method'] == "Debito" ? $fee = $debitFee : null;

        $params['bonificacao'] == 1 ? $valorVenda = 0 : null;
        $params['price'] =  floatval($valorVenda) * $fee;

        Sale::create($params);

        CaixaController::adicionarSaldo($params['price']);
        FinancaController::adicionarVenda($params['price'], $params['order_id']);
        HistoryController::adicionar("VENDA", "Nova venda realizada ");
    }


    public function newOrder($params)
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
