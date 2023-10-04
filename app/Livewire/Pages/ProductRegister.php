<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class ProductRegister extends Component
{

    public $categories = [];
    public $category_id;
    public $name = '';
    public $brand = '';
    public $weight = '';
    public $weight_type = '';
    protected $rules = [
        'category_id' => 'required',
        'name' => 'required',
        'weight' => 'required',
        'weight_type' => 'required',
    ];

    public function mount()
    {
        $this->categories = Category::show();
    }

    public function store()
    {
        $this->validate();

        $product = [
            'category_id' => $this->category_id,
            'name' => $this->name,
            'brand' => $this->brand,
            'weight' => $this->weight . $this->weight_type,
        ];

        Product::create($product);

        return redirect()->route('admin.inventory');
    }

    public function render()
    {
        return view('admin.product_register');
    }
}
