<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Http\Controllers\InventoryController as InventoryController;

class Inventory extends Component
{
    use Actions;

    public $categories = [];
    public $categories_skip = [];

    public $products = [];
    public $lastProducts = [];
    public $total_cost = 0;
    public $total_sale = 0;
    public $total_profit = 0;

    public function mount()
    {
        $this->categories = Category::all();
        $this->categories_skip = json_decode(file_get_contents('../config/app_settings.json'))->stockSkipCategories;
        $this->products = Product::all();
        $this->lastProducts = $this->products->sortByDesc('id')->take(5);
        $this->total_cost = $this->costValueTotal();
        $this->total_sale = $this->saleValueTotal();
        $this->total_profit = $this->profitValue();
    }

    public function costValueTotal()
    {
        $cost_value = 0;
        foreach ($this->products as $product) {
            if (!in_array($product->category_id, $this->categories_skip) && $product->amount > 0) {
                $cost_value += ($product->cost * $product->amount);
            }
        }
        return number_format($cost_value, 2);
    }

    public function saleValueTotal()
    {
        $sale_value = 0;
        foreach ($this->products as $product) {
            if (!in_array($product->category_id, $this->categories_skip) && $product->amount > 0) {
                $sale_value += ($product->sale * $product->amount);
            }
        }
        return number_format($sale_value, 2);
    }

    public function profitValue()
    {
        $sale_value = floatval(str_replace(',', '', $this->saleValueTotal()));
        $cost_value = floatval(str_replace(',', '', $this->costValueTotal()));
        return number_format($sale_value - $cost_value, 2);
    }

    public function deleteDialog(string $id): void
    {
        $product = Product::find($id);
        $this->dialog()->confirm([
            'title' => "#{$product->id} - {$product?->name}  ({$product?->weight}) - {$product?->brand} ",
            'iconColor' => 'primary',
            'description' => "Você tem certeza que deseja excluir o produto do estoque?",
            'accept' => [
                'label' => 'Excluir',
                'method' => 'deleteProduct',
                'params' => $id,
                'color' => 'negative',
            ],
            'reject' => [
                'label' => 'Cancelar',
                'color' => 'info',
            ],
        ]);

    }

    public function deleteProduct($id)
    {
        Product::find($id)->delete();
        $this->products = Product::all();
        $this->notification()->success('Produto excluído com sucesso!');
    }

    public function render()
    {

        return view('admin.inventory');
    }
}
