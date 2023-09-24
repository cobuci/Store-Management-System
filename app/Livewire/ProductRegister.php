<?php

namespace App\Livewire;

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

    public function mount()
    {
        $this->categories = Category::show();
    }

    protected $rules = [
        'category_id' => 'required',
        'name' => 'required',
        'weight' => 'required',
        'weight_type' => 'required',
    ];

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

        $this->reset();
    }

    public function render()
    {
        return view('admin.product_register');
    }
}
