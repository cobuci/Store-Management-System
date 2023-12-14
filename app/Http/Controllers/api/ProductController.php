<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        return Product::all();
    }

    public function addProduct(Request $request, $id): JsonResponse
    {
        $product = Product::findorFail($id);
        if(!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }
        if($request->input('amount') <= 0) {
            return response()->json(['message' => 'Quantidade inválida'], 400);
        }
        if($request->input('cost') <= 0) {
            return response()->json(['message' => 'Custo inválido'], 400);
        }
        if($request->input('sale') <= 0) {
            return response()->json(['message' => 'Preço inválido'], 400);
        }

        $cost = \App\Http\Controllers\ProductController::averageCost($id, $request->input('cost'), $request->input('amount'));

        $product->update([
            'amount' => $product->amount + $request->input('amount'),
            'cost' => $cost,
            'sale' => $request->input('sale'),
        ]);

        $expiration_purchase = now()->day >= 20 ? $expiration_purchase = now()->addMonths(1)->setDay(27) : $expiration_purchase = now()->setDay(27);


        Purchase::create([
            'product_id' => $id,
            'product_name' => $product->name,
            'product_brand' => $product->brand || null,
            'product_weight' => $product->weight,
            'unit_cost' => $request->input('cost'),
            'amount' => $request->input('amount'),
            'payment_status' => 0,
            'expiration_date' => $expiration_purchase,
        ]);


        return response()->json(['message' => 'Produto adicionado com sucesso']);
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
         $product->sale = floatval($product->sale);
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
