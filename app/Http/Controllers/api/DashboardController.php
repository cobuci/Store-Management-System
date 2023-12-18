<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PurchaseController;
use App\Models\Cashier;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function balance(): array
    {
        $cashier = Cashier::find(1);
        $due = Sale::totalDue();

        $result['due'] = $due;
        $result['balance'] = $cashier->balance - $due;
        $result['unpaid'] = PurchaseController::unpaidPurchases();

        $result['balance'] = number_format($result['balance'], 2, '.', '');
        $result['due'] = number_format($result['due'], 2, '.', '');
        $result['unpaid'] = number_format($result['unpaid'], 2, '.', '');

        return $result;
    }

    public function getDue(): array
    {
        $due = Sale::totalDue();

        $result['due'] = $due;
        $result['due'] = number_format($result['due'], 2, '.', '');

        return $result;
    }

    public function getSalesIncomeForLastDays(Int $date = 0): array
    {
        $sales = DB::table('sales')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(price) as total_price'),
            )
            ->groupBy('date')
            ->orderBy('created_at', 'desc')
            ->get();

        $result['sales'] = $sales[$date]->total_price ?? 0;
        $result['sales'] = number_format($result['sales'], 2, '.', '');

        return $result;
    }

    public function getSalesIncomeForLastMonth(Int $date = 0): array
    {
        $sales = DB::table('sales')
            ->select(
                DB::raw('count(id) as `data`'),
                DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
                DB::raw('YEAR(created_at) year, MONTH(created_at) month'),
                DB::raw('SUM(price) as total_price')
            )
            ->groupBy('year', 'month')
            ->orderBy('id', 'desc')
            ->get();

        $result['sales'] = $sales[$date]->total_price ?? "0";
        $result['sales'] = number_format($result['sales'], 2, '.', '');

        return $result;
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
