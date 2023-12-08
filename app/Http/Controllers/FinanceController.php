<?php

namespace App\Http\Controllers;

use App\Models\Finance;
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

    public static function destroy($id)
    {
        $finance = Finance::find($id);

        if ($finance->type == "rdm") {
            CashierController::addBalance($finance->value);
        }
        if ($finance->type == "inv") {
            CashierController::withdrawBalance($finance->value);
        }

        $finance->delete();
    }


    public static function store($value, $description, $type)
    {
        $financa = new Finance();

        $financa->description = $description;
        $financa->type = $type;
        $financa->value = $value;
        $financa->date = Carbon::now()->toDateTimeString();
        $financa->save();
    }
}
