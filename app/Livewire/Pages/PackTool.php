<?php

namespace App\Livewire\Pages;

use App\Models\Product;
use Livewire\Component;
use WireUi\Traits\Actions;

class PackTool extends Component
{

    use Actions;

    public $id_pack_category = 4;
    public $id_product_category = 5;
    public $packs = [];
    public $products = [];

    public $pack = [
        'id' => '',
        'amount' => '',
    ];

    public $product = [
        'id' => '',
        'amount' => '',
    ];

    public $productClose = [
        'id' => '',
        'amount' => '',
    ];

    public $packClose = [
        'id' => '',
        'amount' => '',
    ];

    public function openPack()
    {
        $this->validate([
            'pack.id' => 'required',
            'pack.amount' => 'required',
            'product.id' => 'required',
            'product.amount' => 'required',
        ]);

        $product = Product::find($this->product['id']);
        $product->amount = $product->amount + $this->product['amount'];
        $product->save();

        $pack = Product::find($this->pack['id']);
        $pack->amount = $pack->amount - $this->pack['amount'];
        $pack->save();

        $this->reset();
        $this->mount();

        $this->notification()->success('Abertura do fardo realizada !');
    }

    public function mount()
    {
        $this->packs = $this->getPacks();
        $this->products = $this->getProducts();
    }

    public function getPacks()
    {
        return Product::where('category_id', 'LIKE', $this->id_pack_category)->orderBy('name')->get();
    }

    public function getProducts()
    {
        return Product::where('category_id', 'LIKE', $this->id_product_category)->orderBy('name')->get();
    }

    public function closePack()
    {
        $this->validate([
            'packClose.id' => 'required',
            'packClose.amount' => 'required',
            'productClose.id' => 'required',
            'productClose.amount' => 'required',
        ]);

        $product = Product::find($this->productClose['id']);
        $product->amount = $product->amount - $this->productClose['amount'];
        $product->save();

        $pack = Product::find($this->packClose['id']);
        $pack->amount = $pack->amount + $this->packClose['amount'];
        $pack->save();

        $this->reset();
        $this->mount();

        $this->notification()->success('Fechamento do fardo realizada !');
    }

    public function render()
    {
        return view('admin.tool_pack');
    }
}
