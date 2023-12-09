<?php

namespace App\Livewire\Pages;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class ProductRegister extends Component
{

    public $categories = [];
    public $category_id;
    public string $name = '';
    public string $brand = '';
    public string $upc = '';
    public string $weight = '';
    public string $weight_type = '';
    protected $rules = [
        'category_id' => 'required',
        'name' => 'required',
        'weight' => 'required',
        'weight_type' => 'required',
        'brand' => 'required',
        'upc' => 'nullable',
    ];

    public function mount(): void
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
            'upc' => $this->upc,
        ];

        Product::create($product);

        return redirect()->route('admin.inventory');
    }

    public function render()
    {
        return view('admin.product_register');
    }
}
