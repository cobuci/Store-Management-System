<?php

namespace App\Http\Controllers;


use App\Models\Cashier;
use App\Models\Sale;
use Illuminate\Support\Facades\Cache;

class CashierController extends Controller
{


    public static function balance()
    {
        return Cache::rememberForever('balance', function () {
            $cashier = Cashier::find(1);
            $due = Sale::totalDue();

            return $cashier->balance - $due;
        });
    }


    public static function goal()
    {
        return Cache::rememberForever('goal', fn () => Cashier::find(3)->balance);
    }

    public static function withdrawBalance($value)
    {
        $cashier = Cashier::find(1);
        $cashier->balance -= $value;
        $cashier->save();
        Cache::forget('balance');
    }

    public static function addBalance($value)
    {
        $cashier = Cashier::find(1);
        $cashier->balance += $value;
        $cashier->save();
        Cache::forget('balance');
    }

}
