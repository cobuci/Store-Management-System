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
        return Product::where('upc', $upc)->get()->first();
    }

    public function productStoreUpc(string $upc, int $id): JsonResponse
    {
        $product = Product::find($id);

        if(!$product){
            return response()->json([
                'message' => 'Product not found',
                'product' => $product
            ], 404);
        }

        $product->upc = $upc;
        $product->save();

        if($product->save()){
            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product
            ], 200);
        }

        return response()->json([
            'message' => 'Product not updated',
            'product' => $product
        ], 500);

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
