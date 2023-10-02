<?php

namespace App\Http\Controllers;

use App\Models\Investment;

class InvestimentController extends Controller
{
    public static function withdrawBalance($value, $description, $date)
    {
        InvestimentController::store($value, $description, $date);

        CashierController::addInvestment($value);
        CashierController::withdrawBalance($value);
        FinanceController::balanceInvestment($value, $description, $date, "rdm");
    }

    public static function store($value, $description, $date)
    {
        $investment = new Investment();

        $investment->value = $value;
        $investment->description = $description;
        $investment->date = $date;

        $investment->save();
    }

    public static function addBalance($value, $description, $date)
    {
        InvestimentController::store($value, $description, $date);
        CashierController::withdrawInvestment($value);
        CashierController::addBalance($value);
        FinanceController::balanceInvestment($value, $description, $date, "inv");
    }
}
