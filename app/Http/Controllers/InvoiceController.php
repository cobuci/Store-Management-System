<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Sale;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function show($id)
    {
        if (!Sale::find($id)) {
            return redirect()->back();
        } else {

            $sale = Sale::find($id);

            $orders = $sale->orders;

            $numeroItem = 1;


            return view('admin.invoice', compact('sale', 'orders', 'numeroItem'));
        }
    }
}
