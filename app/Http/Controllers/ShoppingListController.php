<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\DB;

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

        $entrada = new ShoppingList();

        $entrada->produto = $request->produto;
        $entrada->quantidade = $request->quantidade;
        $entrada->custo = $request->custo;

        $entrada->save();
        return redirect('/shoppingList');
    }


    public function calcularTotal()
    {

        $produtos = ShoppingList::select('quantidade', 'custo')
            ->get();
        $total = 0;

        foreach ($produtos as $produto) {
            $total += ($produto->custo * $produto->quantidade);
        }


        return number_format($total, 2);;
    }



    public function destroy($id)
    {
        if (!$produto = ShoppingList::find($id)) {
            return redirect('/shoppingList');
        } else {
            $produto->delete();

            return redirect('/shoppingList');
        }
    }
}
