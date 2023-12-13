<?php

namespace App\Livewire\Pages;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Number;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use WireUi\Traits\Actions;

class Inventory extends Component
{
    use Actions;

    public $products = [];
    public array $categories_skip = [];
    public array $values = [
        'cost' => 0,
        'sale' => 0,
        'profit' => 0,
    ];

    public function mount() : void
    {

        $this->categories_skip = config('pages.inventory.categories_skip');
        $this->products = Product::select('category_id','amount', 'cost', 'sale')->get();
        $this->getValues();

    }

    public function getValues() : void
    {
        $this->values['cost'] = $this->costValueTotal();
        $this->values['sale'] = $this->saleValueTotal();
        $this->values['profit'] = $this->profitValue();
    }

    public function costValueTotal() : string
    {
        $cost_value = 0;
        foreach ($this->products as $product) {
            if (!in_array($product->category_id, $this->categories_skip) && $product->amount > 0) {
                $cost_value += ($product->cost * $product->amount);
            }
        }
        return $cost_value;
    }

    public function saleValueTotal() : string
    {
        $sale_value = 0;
        foreach ($this->products as $product) {
            if (!in_array($product->category_id, $this->categories_skip) && $product->amount > 0) {
                $sale_value += ($product->sale * $product->amount);
            }
        }
        return $sale_value;
    }

    public function profitValue() : string
    {
        $sale_value = floatval($this->saleValueTotal());
        $cost_value = floatval($this->costValueTotal());
        // take the saleValueTotal value , remove the R$ and convert the result  to float


        return Number::currency($sale_value - $cost_value, 'BRL');
    }

    public function placeholder()
    {
        return view('layouts.lazy');
    }

    public function render(): View|Application
    {
        return view('admin.inventory');
    }
}
