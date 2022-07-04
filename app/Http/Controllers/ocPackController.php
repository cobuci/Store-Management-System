<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ocPackController extends Controller
{
    public function index()
    {      

        return view('admin.ocPack', [
           
        ]);
    }

    public function openPack(Request $request){

        $selecPack = Produto::find($request->selectedPack);
        $selecPack->quantidade -= $request->qtProd;

        $prodTarg= Produto::find($request->prodTarget);
        $prodTarg->quantidade += $request->qtProdTarget;

        $prodTarg->save();
        $selecPack->save();

    }
    
    public function closePack(Request $request){

        $selecPack = Produto::find($request->selectedPack);
        $selecPack->quantidade -= $request->qtProd;

        $prodTarg= Produto::find($request->prodTarget);
        $prodTarg->quantidade += $request->qtProdTarget;

        $prodTarg->save();
        $selecPack->save();

    }


}
