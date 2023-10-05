<?php

namespace App\Livewire\Pages;

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Models\Purchase;
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
    public $expiration_purchase;
    public $totalCost = '';


    protected $rules = [
        'product_id' => 'required',
        'amount' => 'required',
        'cost' => 'required',
        'price' => 'required',
        'expiration_purchase' => 'required',
    ];

    public function calculateCost()
    {
        if ($this->amount != null && $this->cost != null) {
            $this->totalCost = $this->amount * $this->cost;
        }
        $this->calculateProfit();
    }

    public function calculateProfit()
    {
        $this->profit = floatval($this->price) - floatval($this->cost);
    }

    public function calculateUnitCost()
    {
        if ($this->amount != null && $this->cost != null) {
            $this->cost = $this->totalCost / $this->amount;
        }
        $this->calculateProfit();

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

        Purchase::create([
            'product_id' => $this->product_id,
            'product_name' => $product->name,
            'product_brand' => $product->brand,
            'product_weight' => $product->weight,
            'unit_cost' => $this->cost,
            'amount' => $this->amount,
            'payment_status' => 0,
            'expiration_date' => $this->expiration_purchase,
        ]);

        HistoryController::addToHistory("ENTRADA", "Compra de ($this->amount - $product->name - $product->brand - $product->weight)");

        $this->reset(['product', 'amount', 'cost', 'price']);
        return redirect()->route('admin.inventory')->with('success', 'Produto adicionado com sucesso!');

    }

    public function mount()
    {
        $this->products = Product::all();
    }

    public function render()
    {
        return view('admin.product_add');
    }
}
