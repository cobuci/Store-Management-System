<?php

namespace App\Livewire\Components;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\Actions;

class EditProduct extends Component
{
    use Actions;
    public bool $cardModal = false;

    public Product $item;
    public $product;

    public $categories;

    protected $rules = [
        'product.name' => 'required|string|max:255',
        'product.brand' => 'required|string|max:255',
        'product.weight' => 'required|string|max:255',
        'product.weight_type' => 'required|string|max:255',
        'product.upc' => 'nullable|string|max:255',
    ];

    public function openModal(): void
    {
        $this->cardModal = true;
        $this->product = Product::find($this->item->id)->toArray();
        $weight_type = preg_replace('/[^a-zA-Z]/', '', $this->product['weight']);
        $this->product['weight'] = preg_replace('/[^0-9]/', '', $this->product['weight']);
        $this->product['weight_type'] = $weight_type;
        $this->product['cost'] = str_replace('.', ',', $this->product['cost']);
        $this->product['sale'] = str_replace('.', ',', $this->product['sale']);
    }




    public function mount(): void
    {
        $this->item = $this->product;
    }

    public function productEdit(): void
    {
        $this->validate();
        $this->product['weight'] = $this->product['weight'] . $this->product['weight_type'];
        $this->product['cost'] = str_replace(',', '.', $this->product['cost']);
        $this->product['sale'] = str_replace(',', '.', $this->product['sale']);
        $this->item->update($this->product);

        $this->cardModal = false;

        $this->notification()->success('Produto editado com sucesso!');
        $this->dispatch('product::updated');

    }

    public function render()
    {
        return view('admin.components.edit-product');
    }
}
