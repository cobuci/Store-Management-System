<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use App\Models\Product;
use App\Models\Venda;

class FinanceController extends Controller
{
    public static function addSale($value)
    {
        $finance = new Finance();

        $finance->value = $value;
        $finance->description = 'Nova Venda realizada';
        $finance->type = "txn";
        $finance->date = \Carbon\Carbon::now()->toDateTimeString();
        $finance->save();
    }

    public static function cancelarVenda($id, $valor)
    {

        $finance = new Finance();
        $descriptor = "Cancelamento da Venda #$id";

        $finance->valor = $valor;
        $finance->descricao = $descriptor;
        $finance->tipo = "CANCELAMENTO";


        $finance->save();
    }

    public static function addProductInventory($product, $value, $amount)
    {
        $product = Product::find($product);

        Finance::create([
            'product_id' => $product->id,
            'product_amount' => $amount,
            'value' => $value,
            'description' => "Compra de ($amount - $product->name - $product->brand - $product->weight)",
            'type' => "wd",
            'date' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }

    public static function adicionarInvestimento($valor, $descricao, $data)
    {

        $financa = new Finance();

        $financa->descricao = $descricao;
        $financa->tipo = "INVESTIMENTO";
        $financa->valor = $valor;
        $financa->data = $data;
        $financa->save();
    }

    public static function resgateInvestimento($valor, $descricao, $data, $tipo = "RESGATE")
    {

        $financa = new Finance();

        $financa->descricao = $descricao;
        $financa->tipo = $tipo;
        $financa->valor = $valor;
        $financa->data = $data;
        $financa->save();
    }

    public function destroy($id)
    {
        $financa = Finance::find($id);

        if ($financa->tipo == "SAIDA") {
            if ($financa->id_produto != 0) {
                ProductController::removeStock($financa->id_produto, $financa->quantidade);
            }
            CashierController::addBalance($financa->valor);
            $financa->delete();
        }
        if ($financa->tipo == "RESGATE") {

            CashierController::addBalance($financa->valor);
            CashierController::removerInvestimento($financa->valor);

            $financa->delete();
        }

        if ($financa->tipo == "INVESTIMENTO") {

            CashierController::withdrawBalance($financa->valor);
            CashierController::adicionarInvestimento($financa->valor);
            $financa->delete();
        }



        return redirect('/financas');
    }
}
