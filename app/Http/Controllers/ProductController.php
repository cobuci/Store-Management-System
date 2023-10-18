<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

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

    public static function findProduct($id)
    {
        return DB::table('products')
            ->where('id', '=', $id)
            ->get();
    }


    public function destroy($id)
    {
        if ($product = Product::find($id)) {
            $product->delete();
            HistoryController::addToHistory("APAGAR", "O Produto $product->name -  $product->weight - $product->brand foi excluido ");
        }
        return redirect()->route('admin.inventory');
    }

}
