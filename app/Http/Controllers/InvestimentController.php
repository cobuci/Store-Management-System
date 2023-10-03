<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Carbon\Carbon;

class InvestimentController extends Controller
{
    public static function withdrawBalance($value, $description)
    {
        InvestimentController::store($value, $description);

        CashierController::addInvestment($value);
        CashierController::withdrawBalance($value);
        FinanceController::balanceInvestment($value, $description, "rdm");
    }

    public static function store($value, $description)
    {
        $investment = new Investment();

        $investment->value = $value;
        $investment->description = $description;
        $investment->date = Carbon::now()->toDateTimeString();

        $investment->save();
    }

    public static function addBalance($value, $description)
    {
        InvestimentController::store($value, $description);
        CashierController::withdrawInvestment($value);
        CashierController::addBalance($value);
        FinanceController::balanceInvestment($value, $description, "inv");
    }
}
