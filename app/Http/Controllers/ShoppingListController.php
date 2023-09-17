<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingList;


class ShoppingListController extends Controller
{
    public function index()
    {
        $list = new ShoppingList;
        $lista = $list->orderBy('id', 'desc')->get();

        $total = ShoppingListController::calcularTotal();

        return view('admin.shoppingList', [
            'lista' => $lista,
            'total' => $total,

        ]);
    }

    public function entradaLista(Request $request)
    {
        ShoppingList::create($request->all());

        return back();
    }


    public function calcularTotal()
    {
        $products = ShoppingList::select('amount', 'cost')
            ->get();
        $total = 0;

        foreach ($products as $product) {
            $total += ($product->cost * $product->amount);
        }

        return number_format($total, 2);
    }


    public function destroy($id)
    {
        if (!$product = ShoppingList::find($id)) {
            return redirect('/shoppingList');
        } else {
            $product->delete();

            return redirect('/shoppingList');
        }
    }
}
