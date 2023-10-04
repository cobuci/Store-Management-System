<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use WireUi\Traits\Actions;


class Inventory extends Component
{
    use Actions;

    public $categories = [];
    public $categories_skip = [];

    public $products = [];
    public $lastProducts = [];

    public $values = [
        'cost' => 0,
        'sale' => 0,
        'profit' => 0,
    ];
    public $cardModal = false;

    public $product = [
        'id' => '',
        'category_id' => '',
        'name' => '',
        'brand' => '',
        'weight' => '',
        'weight_type' => '',
        'amount' => '',
        'expiration_date' => '',
        'cost' => '',
        'sale' => '',
    ];

    protected $rules = [
        'product.name' => 'required',
        'product.brand' => 'required',
        'product.weight' => 'required',
        'product.weight_type' => 'required',
    ];



    public function modalCardEdit(string $id) : void
    {
        $this->cardModal = true;
        $this->product = Product::find($id)->toArray();

        $weight_type = preg_replace('/[^a-zA-Z]/', '', $this->product['weight']);
        $this->product['weight'] = preg_replace('/[^0-9]/', '', $this->product['weight']);
        $this->product['weight_type'] = $weight_type;
        $this->product['cost'] = str_replace('.', ',', $this->product['cost']);
        $this->product['sale'] = str_replace('.', ',', $this->product['sale']);
    }

    public function productEdit() : void
    {
        $this->validate();
        $this->product['weight'] = $this->product['weight'] . $this->product['weight_type'];
        $this->product['cost'] = str_replace(',', '.', $this->product['cost']);
        $this->product['sale'] = str_replace(',', '.', $this->product['sale']);
        Product::find($this->product['id'])->update($this->product);
        $this->cardModal = false;

        $this->notification()->success('Produto editado com sucesso!');
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

    public function deleteProduct($id) : void
    {
        Product::find($id)->delete();
        $this->mount();
        $this->notification()->success('Produto excluído com sucesso!');
    }

    public function mount() : void
    {
        $this->categories = Category::all();
        $this->categories_skip = json_decode(file_get_contents('../config/app_settings.json'))->stockSkipCategories;
        $this->products = Product::all();
        $this->lastProducts = $this->products->sortByDesc('id')->take(5);
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
        return number_format($cost_value, 2);
    }

    public function saleValueTotal() : string
    {
        $sale_value = 0;
        foreach ($this->products as $product) {
            if (!in_array($product->category_id, $this->categories_skip) && $product->amount > 0) {
                $sale_value += ($product->sale * $product->amount);
            }
        }
        return number_format($sale_value, 2);
    }

    public function profitValue() : string
    {
        $sale_value = floatval(str_replace(',', '', $this->saleValueTotal()));
        $cost_value = floatval(str_replace(',', '', $this->costValueTotal()));
        return number_format($sale_value - $cost_value, 2);
    }

    public function render()
    {
        return view('admin.inventory');
    }
}
