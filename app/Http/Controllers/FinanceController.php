<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Product;
use Carbon\Carbon;

class FinanceController extends Controller
{
    public static function addSale($value)
    {
        $finance = new Finance();

        $finance->value = $value;
        $finance->description = 'Nova Venda realizada';
        $finance->type = "txn";
        $finance->date = Carbon::now()->toDateTimeString();
        $finance->save();
    }

    public static function cancelSale($id, $value)
    {
        Finance::create([
            'value' => $value,
            'description' => "Cancelamento da Venda #$id",
            'type' => "rev",
        ]);
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
            'date' => Carbon::now()->toDateTimeString(),
        ]);
    }

    public static function destroy($id)
    {
        $finance = Finance::find($id);

        if ($finance->type == "wd") {
            if ($finance->product_id != 0) {
                ProductController::removeStock($finance->product_id, $finance->product_amount);
            }
            CashierController::addBalance($finance->value);
        }
        if ($finance->type == "rdm") {
            CashierController::addBalance($finance->value);
            CashierController::withdrawInvestment($finance->value);
        }
        if ($finance->type == "inv") {
            CashierController::withdrawBalance($finance->value);
            CashierController::addInvestment($finance->value);
        }

        $finance->delete();
    }


    public static function balanceInvestment($value, $description, $date, $type)
    {
        $financa = new Finance();

        $financa->description = $description;
        $financa->type = $type;
        $financa->value = $value;
        $financa->date = $date;
        $financa->save();
    }
}
