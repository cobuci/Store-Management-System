<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{

    public static function averageCost(mixed $product_id, mixed $cost, mixed $amount)
    {
        $product = Product::find($product_id);
        $product->cost = ($product->cost * $product->amount + $cost * $amount) / ($product->amount + $amount);
        $product->save();
        return $product->cost;
    }

    public static function removeStock($id, $amount)
    {
        $product = Product::find($id);
        $product->amount -= $amount;
        $product->save();
    }

    public static function addStock($id, $amount)
    {
        $product = Product::find($id);
        $product->amount += $amount;
        $product->save();
    }

}
