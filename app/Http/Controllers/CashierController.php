<?php

namespace App\Http\Controllers;


use App\Models\Cashier;
use App\Models\Sale;

class CashierController extends Controller
{


    public static function balance()
    {
        $cashier = Cashier::find(1);
        $due = Sale::totalDue();

        return $cashier->balance - $due;
    }


    public static function goal()
    {
        return Cashier::find(3)->balance;
    }

    public static function withdrawBalance($value)
    {
        $cashier = Cashier::find(1);
        $cashier->balance -= $value;
        $cashier->save();
    }
    public static function withdrawInvestment($value)
    {
        $cashier = Cashier::find(2);
        $cashier->balance -= $value;
        $cashier->save();
    }

    public static function addBalance($value)
    {
        $cashier = Cashier::find(1);
        $cashier->balance += $value;
        $cashier->save();
    }

    public static function addInvestment($value)
    {
        $cashier = Cashier::find(2);
        $cashier->balance += $value;
        $cashier->save();
    }



}
