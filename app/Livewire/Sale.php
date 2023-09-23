<?php

namespace App\Livewire;

use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Livewire\Component;

class Sale extends Component
{


    public $products;
    public $product;

    public $amount;
    public $list = [];
    public $customers = [];
    public $discount = 0;
    public $price = 0;


    public function addProduct()
    {
        $product = Product::find($this->product);
        $this->list[] = [
            'name' => $product->name,
            'brand' => $product->brand,
            'weight' => $product->weight,
            'product' => $this->product,
            'amount' => $this->amount,
        ];
        $this->reset(['product', 'amount']);
    }

    public function mount(): void
    {
        $this->customers = Customer::show();
        $this->products = Product::get();
    }

    public function render()
    {
        return view('admin.sale_page');
    }
}
