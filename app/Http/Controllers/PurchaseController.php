<?php

namespace App\Http\Controllers;

use App\Models\Purchase;

class PurchaseController extends Controller
{
    public static function unpaidPurchases()
    {
        $unpaidPurchases = Purchase::where('payment_status', 0)->get();
        $totalCost = 0;
        foreach ($unpaidPurchases as $purchase) {
            $totalCost += $purchase->unit_cost * $purchase->amount;
        }
        return $totalCost;
    }

    public static function destroy($id)
    {
        $purchase = Purchase::find($id);
        if ($purchase->product_id != 0) {
            ProductController::removeStock($purchase->product_id, $purchase->amount);
        }
        $purchase->delete();
    }

    public function index()
    {

    }

}
