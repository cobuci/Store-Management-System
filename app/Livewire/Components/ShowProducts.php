<?php

namespace App\Livewire\Components;


use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Models\Product;

use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;

use Livewire\Component;
use WireUi\Traits\Actions;

class ShowProducts extends Component
{
    use Actions;

    public array|Collection  $categories = [];

    public array|Collection  $products = [];
    public array|Collection $lastProducts = [];

    public bool $cardModal = false;

    protected $listeners = [
        'product::updated' => '$refresh',

    ];

    public array $product = [
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

    protected array $rules = [
        'product.name' => 'required',
        'product.brand' => 'required',
        'product.weight' => 'required',
        'product.weight_type' => 'required',
    ];

    public function modalCardEdit(string $id): void
    {
        $this->cardModal = true;
        $this->product = Product::find($id)->toArray();

        $weight_type = preg_replace('/[^a-zA-Z]/', '', $this->product['weight']);
        $this->product['weight'] = preg_replace('/[^0-9]/', '', $this->product['weight']);
        $this->product['weight_type'] = $weight_type;
        $this->product['cost'] = str_replace('.', ',', $this->product['cost']);
        $this->product['sale'] = str_replace('.', ',', $this->product['sale']);
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

    public function deleteProduct($id): void
    {
        Product::find($id)->delete();
        $this->mount();
        $this->notification()->success('Produto excluído com sucesso!');
    
    }



    public function mount(): void
    {
        $this->categories = CategoryController::show();

        $this->lastProducts = Product::select('id', 'name', 'brand', 'weight', 'cost', 'sale', 'amount', 'expiration_date')
            ->orderByDesc('id')
            ->take(5)
            ->get();
    }
    public function render(): View|Application
    {
        return view('admin.components.show-products');
    }
}
