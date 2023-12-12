<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        return Product::all();
    }

    public function productsByCategory(string $id)
    {
        return Product::where('category_id', $id)->get();
    }

    public function productsByUpc(string $upc)
    {
       $product = Product::where('upc', $upc)->get()->first();

         if (!$product) {
              return response()->json(['message' => 'Produto não encontrado'], 404);
         }
         $product->sale = number_format($product->sale,2);
         $product->cost = number_format($product->cost,2);
         $product->amount = floatval($product->amount);


        return $product;
    }

    public function productStoreUpc(Request $request, $id): JsonResponse
    {
        $product = Product::findorFail($id);
        $product->update([
            'upc' => $request->input('upc')
        ]);

        return response()->json(['message' => 'Produto atualizado com sucesso']);


    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
       return Product::findOrFail($id);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
