<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
        return Product::where('upc', $upc)->get();
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
