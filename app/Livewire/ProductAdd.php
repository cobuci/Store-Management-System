<?php

namespace App\Livewire;

use App\Http\Controllers\ProductController;
use App\Models\Product;
use Livewire\Component;
use WireUi\Traits\Actions;


class ProductAdd extends Component
{

    use Actions;

    public $products = [];
    public $product_id = '';
    public $amount = '';
    public $cost = '';
    public $price = '';
    public $profit = '';
    public $expiration_date;
    public $totalCost = '';


    protected $rules = [
        'product_id' => 'required',
        'amount' => 'required',
        'cost' => 'required',
        'price' => 'required',
    ];

    public function calculateCost()
    {
        if ($this->amount != null && $this->cost != null) {
            $this->totalCost = $this->amount * $this->cost;
        }
        $this->profit();
    }


    public function calculateUnitCost()
    {
        if ($this->amount != null && $this->cost != null) {
            $this->cost = $this->totalCost / $this->amount;
        }
        $this->profit();

    }

    public function addProduct()
    {
        $this->validate();
        $product = Product::find($this->product_id);

        $product->amount += $this->amount;

        $cost = ProductController::averageCost($this->product_id, $this->cost, $this->amount);

        $product->cost = $cost;
        $product->sale = $this->price;
        $product->expiration_date = $this->expiration_date;
        $product->save();

//        $this->reset(['product', 'amount', 'cost', 'price']);
        return redirect()->route('admin.inventory')->with('success', 'Produto adicionado com sucesso!')            ;

    }

    public function mount()
    {
        $this->products = Product::all();
    }

    public function profit()
    {
        $this->profit = floatval($this->price) - floatval($this->cost);
    }

    public function render()
    {
        return view('admin.product_add');
    }
}
