<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class InventoryController extends Controller
{
    private static array|Collection $products = [];
    private static array $categories_skip = [];

    public function __construct()
    {
        self::$products = Product::all();
        self::$categories_skip = json_decode(file_get_contents('../config/app_settings.json'))->stockSkipCategories;
    }

    public function index()
    {
        $cost_value = self::costValueTotal();
        $sale_value = self::saleValueTotal();
        $profit_value = self::profitValue();
        $lastProducts = self::getLastProducts();
        $categories = CategoryController::show();
        $products = self::$products->sortBy('name');

        return view('admin.inventory', compact('cost_value', 'products', 'profit_value', 'sale_value', 'lastProducts', 'categories'));
    }

    public  function costValueTotal(): string
    {
        $cost_value = 0;

        foreach (self::$products as $product) {
            if (!in_array($product->category_id, self::$categories_skip) && $product->amount > 0) {
                $cost_value += ($product->cost * $product->amount);
            }
        }
        return number_format($cost_value, 2);
    }

    public  function saleValueTotal(): string
    {
        $sale_value = 0;

        foreach (self::$products as $product) {
            if (!in_array($product->category_id, self::$categories_skip) && $product->amount > 0) {
                $sale_value += ($product->sale * $product->amount);
            }
        }
        return number_format($sale_value, 2);
    }

    public  function profitValue(): string
    {
        $sale_value = floatval(str_replace(',', '', self::saleValueTotal()));
        $cost_value = floatval(str_replace(',', '', self::costValueTotal()));
        return number_format($sale_value - $cost_value, 2);
    }

    public function getLastProducts()
    {
        return Product::orderBy('id', 'desc')->take(5)->get();
    }


}
