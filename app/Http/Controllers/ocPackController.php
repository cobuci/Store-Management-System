<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ocPackController extends Controller
{
    public function index()
    {

        return view('admin.ocPack', []);
    }

    public function openPack(Request $request)
    {

        $selecPack = Product::find($request->selectedPack);
        $selecPack->quantidade -= $request->qtProd;

        $prodTarg = Product::find($request->prodTarget);
        $prodTarg->quantidade += $request->qtProdTarget;

        $prodTarg->save();
        $selecPack->save();


        HistoryController::adicionar("PACK", "Trocou $request->qtProd caixas de $selecPack->marca ($selecPack->peso) por $request->qtProdTarget un. de $prodTarg->marca ($prodTarg->peso)");

        return redirect('/historico');
    }

    public function closePack(Request $request)
    {

        $selecPack = Product::find($request->selectedPack);
        $selecPack->quantidade -= $request->qtProd;

        $prodTarg = Product::find($request->prodTarget);
        $prodTarg->quantidade += $request->qtProdTarget;

        $prodTarg->save();
        $selecPack->save();


        HistoryController::adicionar("PACK", "Trocou $request->qtProd un. de $selecPack->marca ($selecPack->peso) por $request->qtProdTarget caixas de $prodTarg->marca ($prodTarg->peso) ");


        return redirect('/historico');
    }
}
